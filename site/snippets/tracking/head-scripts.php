<!-- Google Tag Manager -->
<?php if ($gtmId = $site->settingsIntegrations()->google_tag_manager_id()): ?>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?= $gtmId ?>');</script>
<?php endif ?>
<!-- End Google Tag Manager -->

<!-- Facebook Pixel -->
<?php if ($fbPixelId = $site->settingsIntegrations()->facebook_pixel_id()): ?>
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '<?= $fbPixelId ?>');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=<?= $fbPixelId ?>&ev=PageView&noscript=1"
/></noscript>
<?php endif ?>

<!-- TikTok Pixel -->
<?php if ($tiktokPixelId = $site->settingsIntegrations()->tiktok_pixel_id()): ?>
<script>
!function (w, d, t) {
  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","ready","alias","debug","on","off","once","reset","setGroup","setId"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;r+=o?"?partner="+o:"";const i=d.createElement("script");i.setAttribute("type","text/javascript"),i.setAttribute("src",r),i.setAttribute("async",!0),d.head.appendChild(i),ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq.load=e};
  ttq.load('<?= $tiktokPixelId ?>');
  ttq.page();
}(window, document, 'ttq');
</script>
<?php endif ?>

<!-- Snapchat Pixel -->
<?php if ($snapchatPixelId = $site->settingsIntegrations()->snapchat_pixel_id()): ?>
<script type="text/javascript">
(function(e,t,o,n,p,r,a){e.Snaptr=e.Snaptr||function(){(e.Snaptr.q=e.Snaptr.q||[]).push(arguments)};p=e.snaptr;p();p.attributionWindow=o;n=p._isAsyncInit=!0;r=t.createElement("script");r.src=a;r.async=!0;t.getElementsByTagName("head")[0].appendChild(r);a=e.snaptr.appIds=e.snaptr.appIds||{};a["<?= $snapchatPixelId ?>"]={pixelId:"<?= $snapchatPixelId ?>"};})(window,document,3600,"https://sc-static.net/scevent.min.js");
snaptr('init', '<?= $snapchatPixelId ?>');
snaptr('track', 'PAGE_VIEW');
</script>
<?php endif ?>

<!-- UTM Parameters Tracking -->
<script>
(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const utmParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
    let hasUtm = false;
    
    utmParams.forEach(param => {
        if (urlParams.has(param)) {
            localStorage.setItem(param, urlParams.get(param));
            hasUtm = true;
        }
    });
    
    // Also store in data attributes for form submission
    if (hasUtm) {
        document.documentElement.setAttribute('data-utm-source', localStorage.getItem('utm_source') || '');
        document.documentElement.setAttribute('data-utm-medium', localStorage.getItem('utm_medium') || '');
        document.documentElement.setAttribute('data-utm-campaign', localStorage.getItem('utm_campaign') || '');
        document.documentElement.setAttribute('data-utm-term', localStorage.getItem('utm_term') || '');
        document.documentElement.setAttribute('data-utm-content', localStorage.getItem('utm_content') || '');
    }
})();
</script>
