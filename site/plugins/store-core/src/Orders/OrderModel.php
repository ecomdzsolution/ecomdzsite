<?php

namespace Store\Core\Orders;

use Kirby\Cms\App;
use Kirby\Database\Db;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Exception\NotFoundException;
use Kirby\Toolkit\Str;

/**
 * Order Model
 * 
 * Handles all order-related operations with SQLite storage
 */
class OrderModel
{
    private static ?Db $db = null;
    
    /**
     * Initialize database connection
     */
    public static function db(): Db
    {
        if (self::$db === null) {
            $dbPath = __DIR__ . '/../../../storage/db/orders.sqlite';
            
            // Ensure directory exists
            $dir = dirname($dbPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            self::$db = new Db([
                'type' => 'sqlite',
                'root' => $dbPath
            ]);
            
            self::createTables();
        }
        
        return self::$db;
    }
    
    /**
     * Create database tables if they don't exist
     */
    private static function createTables(): void
    {
        $db = self::db();
        
        // Orders table
        $db->execute("
            CREATE TABLE IF NOT EXISTS orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_number VARCHAR(50) UNIQUE NOT NULL,
                status VARCHAR(50) DEFAULT 'pending',
                customer_name VARCHAR(255) NOT NULL,
                customer_email VARCHAR(255),
                customer_phone VARCHAR(50) NOT NULL,
                customer_address TEXT,
                wilaya_id INTEGER,
                wilaya_name VARCHAR(100),
                commune VARCHAR(100),
                delivery_type VARCHAR(50) DEFAULT 'home',
                shipping_cost DECIMAL(10,2) DEFAULT 0,
                subtotal DECIMAL(10,2) NOT NULL,
                tax_amount DECIMAL(10,2) DEFAULT 0,
                discount_amount DECIMAL(10,2) DEFAULT 0,
                total_amount DECIMAL(10,2) NOT NULL,
                payment_method VARCHAR(50) DEFAULT 'cod',
                payment_status VARCHAR(50) DEFAULT 'unpaid',
                notes TEXT,
                utm_source VARCHAR(100),
                utm_medium VARCHAR(100),
                utm_campaign VARCHAR(100),
                utm_term VARCHAR(100),
                utm_content VARCHAR(100),
                fbclid VARCHAR(100),
                gclid VARCHAR(100),
                ttclid VARCHAR(100),
                ip_address VARCHAR(45),
                user_agent TEXT,
                fraud_score INTEGER DEFAULT 0,
                fraud_flags TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                completed_at DATETIME,
                cancelled_at DATETIME
            )
        ");
        
        // Order items table
        $db->execute("
            CREATE TABLE IF NOT EXISTS order_items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER NOT NULL,
                product_id VARCHAR(255) NOT NULL,
                product_name VARCHAR(255) NOT NULL,
                product_sku VARCHAR(100),
                variant_name VARCHAR(100),
                quantity INTEGER NOT NULL DEFAULT 1,
                unit_price DECIMAL(10,2) NOT NULL,
                total_price DECIMAL(10,2) NOT NULL,
                FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
            )
        ");
        
        // Order status history
        $db->execute("
            CREATE TABLE IF NOT EXISTS order_status_history (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER NOT NULL,
                old_status VARCHAR(50),
                new_status VARCHAR(50) NOT NULL,
                note TEXT,
                changed_by VARCHAR(100),
                changed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
            )
        ");
        
        // Create indexes
        $db->execute("CREATE INDEX IF NOT EXISTS idx_orders_status ON orders(status)");
        $db->execute("CREATE INDEX IF NOT EXISTS idx_orders_created ON orders(created_at)");
        $db->execute("CREATE INDEX IF NOT EXISTS idx_orders_customer ON orders(customer_phone)");
        $db->execute("CREATE INDEX IF NOT EXISTS idx_orders_wilaya ON orders(wilaya_id)");
        $db->execute("CREATE INDEX IF NOT EXISTS idx_order_items_order ON order_items(order_id)");
    }
    
    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        $prefix = kirby()->option('store.orderPrefix', 'DZ');
        $digits = kirby()->option('store.orderDigits', 6);
        
        do {
            $random = str_pad(random_int(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
            $orderNumber = strtoupper($prefix) . $random;
        } while (self::findByNumber($orderNumber) !== null);
        
        return $orderNumber;
    }
    
    /**
     * Create a new order
     */
    public static function create(array $data): array
    {
        $db = self::db();
        
        // Validate required fields
        $required = ['customer_name', 'customer_phone', 'items'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new InvalidArgumentException("Missing required field: {$field}");
            }
        }
        
        $orderNumber = self::generateOrderNumber();
        
        // Calculate totals
        $subtotal = 0;
        foreach ($data['items'] as $item) {
            $subtotal += ($item['unit_price'] * $item['quantity']);
        }
        
        $taxAmount = $data['tax_amount'] ?? 0;
        $discountAmount = $data['discount_amount'] ?? 0;
        $shippingCost = $data['shipping_cost'] ?? 0;
        $totalAmount = $subtotal + $taxAmount + $shippingCost - $discountAmount;
        
        // Insert order
        $orderId = $db->insert('orders', [
            'order_number' => $orderNumber,
            'status' => $data['status'] ?? 'pending',
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'] ?? null,
            'customer_phone' => $data['customer_phone'],
            'customer_address' => $data['customer_address'] ?? null,
            'wilaya_id' => $data['wilaya_id'] ?? null,
            'wilaya_name' => $data['wilaya_name'] ?? null,
            'commune' => $data['commune'] ?? null,
            'delivery_type' => $data['delivery_type'] ?? 'home',
            'shipping_cost' => $shippingCost,
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'payment_method' => $data['payment_method'] ?? 'cod',
            'payment_status' => 'unpaid',
            'notes' => $data['notes'] ?? null,
            'utm_source' => $data['utm']['source'] ?? null,
            'utm_medium' => $data['utm']['medium'] ?? null,
            'utm_campaign' => $data['utm']['campaign'] ?? null,
            'utm_term' => $data['utm']['term'] ?? null,
            'utm_content' => $data['utm']['content'] ?? null,
            'fbclid' => $data['fbclid'] ?? null,
            'gclid' => $data['gclid'] ?? null,
            'ttclid' => $data['ttclid'] ?? null,
            'ip_address' => kirby()->request()->ip(),
            'user_agent' => kirby()->request()->userAgent(),
            'fraud_score' => 0,
            'fraud_flags' => null,
        ]);
        
        // Insert order items
        foreach ($data['items'] as $item) {
            $db->insert('order_items', [
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'product_sku' => $item['product_sku'] ?? null,
                'variant_name' => $item['variant_name'] ?? null,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['unit_price'] * $item['quantity'],
            ]);
        }
        
        // Log status change
        self::logStatusChange($orderId, null, 'pending', 'Order created');
        
        // Return full order data
        return self::findById($orderId);
    }
    
    /**
     * Find order by ID
     */
    public static function findById(int $orderId): ?array
    {
        $db = self::db();
        $order = $db->table('orders')->find($orderId);
        
        if (!$order) {
            return null;
        }
        
        // Get order items
        $items = $db->table('order_items')
            ->where('order_id', $orderId)
            ->all();
        
        $order['items'] = $items;
        
        // Get status history
        $history = $db->table('order_status_history')
            ->where('order_id', $orderId)
            ->orderBy('changed_at', 'desc')
            ->all();
        
        $order['status_history'] = $history;
        
        return $order;
    }
    
    /**
     * Find order by order number
     */
    public static function findByNumber(string $orderNumber): ?array
    {
        $db = self::db();
        $order = $db->table('orders')
            ->where('order_number', $orderNumber)
            ->first();
        
        if (!$order) {
            return null;
        }
        
        return self::findById($order['id']);
    }
    
    /**
     * Update order status
     */
    public static function updateStatus(int $orderId, string $newStatus, ?string $note = null, ?string $changedBy = null): bool
    {
        $db = self::db();
        $order = self::findById($orderId);
        
        if (!$order) {
            throw new NotFoundException("Order not found");
        }
        
        $oldStatus = $order['status'];
        $updateData = ['status' => $newStatus, 'updated_at' => date('Y-m-d H:i:s')];
        
        // Set completion/cancellation timestamp
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            $updateData['completed_at'] = date('Y-m-d H:i:s');
        } elseif ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            $updateData['cancelled_at'] = date('Y-m-d H:i:s');
        }
        
        $db->table('orders')
            ->where('id', $orderId)
            ->update($updateData);
        
        // Log status change
        self::logStatusChange($orderId, $oldStatus, $newStatus, $note, $changedBy);
        
        return true;
    }
    
    /**
     * Update order
     */
    public static function update(int $orderId, array $data): bool
    {
        $db = self::db();
        
        $allowedFields = [
            'customer_name', 'customer_email', 'customer_phone',
            'customer_address', 'wilaya_id', 'wilaya_name', 'commune',
            'delivery_type', 'shipping_cost', 'notes', 'payment_status'
        ];
        
        $updateData = [];
        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $updateData[$field] = $data[$field];
            }
        }
        
        $updateData['updated_at'] = date('Y-m-d H:i:s');
        
        return $db->table('orders')
            ->where('id', $orderId)
            ->update($updateData) !== false;
    }
    
    /**
     * Log status change
     */
    private static function logStatusChange(
        int $orderId,
        ?string $oldStatus,
        string $newStatus,
        ?string $note = null,
        ?string $changedBy = null
    ): void {
        self::db()->insert('order_status_history', [
            'order_id' => $orderId,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'note' => $note,
            'changed_by' => $changedBy ?? 'system',
            'changed_at' => date('Y-m-d H:i:s'),
        ]);
    }
    
    /**
     * Get orders with pagination and filters
     */
    public static function getOrders(array $filters = [], int $page = 1, int $limit = 20): array
    {
        $db = self::db();
        $query = $db->table('orders');
        
        // Apply filters
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }
        
        if (!empty($filters['wilaya_id'])) {
            $query->where('wilaya_id', $filters['wilaya_id']);
        }
        
        if (!empty($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }
        
        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $query->filter(function ($row) use ($search) {
                return stripos($row['order_number'], $search) !== false
                    || stripos($row['customer_name'], $search) !== false
                    || stripos($row['customer_phone'], $search) !== false
                    || stripos($row['customer_email'], $search) !== false;
            });
        }
        
        // Get total count
        $total = $query->count();
        
        // Apply pagination
        $offset = ($page - 1) * $limit;
        $orders = $query
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->all();
        
        return [
            'orders' => $orders,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'pages' => ceil($total / $limit),
            ],
        ];
    }
    
    /**
     * Get order statistics
     */
    public static function getStatistics(?string $dateFrom = null, ?string $dateTo = null): array
    {
        $db = self::db();
        $query = $db->table('orders');
        
        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo);
        }
        
        $orders = $query->all();
        
        $totalOrders = count($orders);
        $totalRevenue = 0;
        $pendingOrders = 0;
        $completedOrders = 0;
        $cancelledOrders = 0;
        
        foreach ($orders as $order) {
            $totalRevenue += floatval($order['total_amount']);
            
            switch ($order['status']) {
                case 'pending':
                    $pendingOrders++;
                    break;
                case 'completed':
                    $completedOrders++;
                    break;
                case 'cancelled':
                    $cancelledOrders++;
                    break;
            }
        }
        
        return [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
            'cancelled_orders' => $cancelledOrders,
            'average_order_value' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
        ];
    }
    
    /**
     * Delete order (soft delete by setting status to cancelled)
     */
    public static function delete(int $orderId): bool
    {
        return self::updateStatus($orderId, 'cancelled', 'Order deleted');
    }
}
