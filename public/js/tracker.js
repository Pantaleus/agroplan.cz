window.initTracker = function() {
    // Generování nebo načtení Session ID
    function getVisitorId() {
        let visitorId = localStorage.getItem('agroplan_visitor_id');
        if (!visitorId) {
            visitorId = 'v_' + Math.random().toString(36).substr(2, 9) + Date.now();
            localStorage.setItem('agroplan_visitor_id', visitorId);
            localStorage.setItem('agroplan_is_new', '1');
        } else {
            localStorage.setItem('agroplan_is_new', '0');
        }
        return visitorId;
    }

    const sessionId = getVisitorId();
    const isNew = localStorage.getItem('agroplan_is_new') === '1';
    
    // Čas a Scroll
    const startTime = Date.now();
    let maxScroll = 0;
    
    window.addEventListener('scroll', () => {
        const scrollPercent = Math.round((window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100);
        if (scrollPercent > maxScroll) {
            maxScroll = scrollPercent;
        }
    });

    // Detekce zařízení, OS, prohlížeče
    const resolution = window.screen.width + 'x' + window.screen.height;
    const url = window.location.pathname;
    
    // Odeslání dat
    function sendTrackingData() {
        const timeSpent = Math.round((Date.now() - startTime) / 1000); // V sekundách
        const data = {
            session_id: sessionId,
            is_new: isNew,
            resolution: resolution,
            url: url,
            max_scroll: maxScroll,
            time_spent: timeSpent,
            referrer: document.referrer || '',
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
        };

        // Odeslání pomocí fetch (spolehlivější pro JSON payload v PHP)
        fetch('/api/track', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
            keepalive: true
        }).catch(err => console.error("Tracking error", err));
    }

    // Odeslat data před opuštěním stránky
    window.addEventListener('beforeunload', sendTrackingData);
    window.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') {
            sendTrackingData();
        }
    });

    // Prvotní ping, aby se zaznamenala návštěva hned
    setTimeout(sendTrackingData, 2000);
    // Ping každých 15 vteřin pro jistotu u dlouhých návštěv
    setInterval(sendTrackingData, 15000);

};
