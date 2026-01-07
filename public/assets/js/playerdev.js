// playerdev.js v3 - Monthly Prayer Data Compatible Version
(function() {
    'use strict';

    // Global variables with namespace protection
    var PlayerDevModule = {
        config: null,
        showFuncReminder: 0,
        nextAdzanName: '',
        nextAdzanTime: null,
        SubuhTime: null,
        IsyaTime: null,
        data: null,
        isReloadPage: 0, // This will be removed as we no longer need page reload
        isInitialized: false,
        monthlyPrayerData: {} // Store monthly prayer data
    };

    // Timer management - centralized interval tracking with better isolation
    window.TimerManager = window.TimerManager || {
        intervals: new Map(),

        setInterval: function(callback, delay, id) {
            const uniqueId = id + '_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

            if (this.intervals.has(id)) {
                this.clearInterval(id);
            }

            try {
                const intervalId = setInterval(callback, delay);
                this.intervals.set(id, {
                    intervalId: intervalId,
                    uniqueId: uniqueId,
                    created: new Date(),
                    callback: callback.toString().substring(0, 100) + '...'
                });

                console.log(`[TimerManager] Set interval: ${id} (${uniqueId})`);
                return intervalId;
            } catch (error) {
                console.error(`[TimerManager] Error setting interval ${id}:`, error);
                return null;
            }
        },

        clearInterval: function(id) {
            if (this.intervals.has(id)) {
                const timerData = this.intervals.get(id);
                clearInterval(timerData.intervalId);
                this.intervals.delete(id);
                console.log(`[TimerManager] Cleared interval: ${id} (${timerData.uniqueId})`);
                return true;
            }
            return false;
        },

        clearAll: function() {
            console.log(`[TimerManager] Clearing all ${this.intervals.size} intervals`);
            this.intervals.forEach((timerData, id) => {
                clearInterval(timerData.intervalId);
                console.log(`[TimerManager] Cleared: ${id} (${timerData.uniqueId})`);
            });
            this.intervals.clear();
        },

        getActiveTimers: function() {
            return Array.from(this.intervals.entries()).map(([id, data]) => ({
                id: id,
                uniqueId: data.uniqueId,
                created: data.created,
                callback: data.callback
            }));
        }
    };

    // DOM element cache for better performance with namespace protection
    window.DOMCache = window.DOMCache || {
        elements: new Map(),

        get: function(selector) {
            if (!this.elements.has(selector)) {
                try {
                    const element = $(selector);
                    if (element.length > 0) {
                        this.elements.set(selector, element);
                    } else {
                        console.warn(`[DOMCache] Element not found: ${selector}`);
                        return $(); // Return empty jQuery object
                    }
                } catch (error) {
                    console.error(`[DOMCache] Error getting element ${selector}:`, error);
                    return $();
                }
            }
            return this.elements.get(selector);
        },

        clear: function() {
            console.log(`[DOMCache] Clearing ${this.elements.size} cached elements`);
            this.elements.clear();
        },

        refresh: function(selector) {
            if (this.elements.has(selector)) {
                this.elements.delete(selector);
            }
            return this.get(selector);
        }
    };

    // Fullscreen handling with improved error handling
    window.openFullscreen = function(elem) {
        try {
            if (elem.requestFullscreen) {
                return elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) {
                return elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                return elem.msRequestFullscreen();
            }

            $('#full-screen-modal').modal('hide');
        } catch (error) {
            console.error('[PlayerDev] Fullscreen error:', error);
        }
    };

    // Get today's date key for prayer data lookup
    function getTodayKey() {
        const today = new Date();
        return today.getFullYear() + '-' +
            String(today.getMonth() + 1).padStart(2, '0') + '-' +
            String(today.getDate()).padStart(2, '0');
    }

    // Get prayer time for specific date and prayer name
    function getPrayerTimeFromData(date, prayerName) {
        try {
            if (window.MasjidPlayer && window.MasjidPlayer.prayerData && window.MasjidPlayer.prayerData.monthly) {
                const dateKey = date || getTodayKey();
                const dayData = window.MasjidPlayer.prayerData.monthly[dateKey];

                if (dayData && dayData[prayerName]) {
                    return dayData[prayerName];
                }
            }

            // Fallback to element data if monthly data not available
            const element = DOMCache.get(`[data-name="${prayerName}"]`);
            if (element.length > 0) {
                return element.attr('data-time') || '00:00';
            }

            console.warn(`[PlayerDev] Prayer time not found for ${prayerName} on ${date}`);
            return '00:00';

        } catch (error) {
            console.error('[PlayerDev] Error getting prayer time from data:', error);
            return '00:00';
        }
    }

    // Update prayer times for date change
    function updatePrayerTimesForNewDay() {
        try {
            const todayKey = getTodayKey();
            console.log(`[PlayerDev] Updating prayer times for new day: ${todayKey}`);

            // Reset next adzan tracking for new day
            PlayerDevModule.nextAdzanName = '';
            PlayerDevModule.nextAdzanTime = null;

            // Update each prayer element with new times
            const prayerElements = DOMCache.get('#prayer').children();

            prayerElements.each(function() {
                const element = $(this);
                const prayerName = element.attr('data-name');

                if (prayerName) {
                    const newTime = getPrayerTimeFromData(todayKey, prayerName);
                    element.attr('data-time', newTime);

                    // Update display
                    const timeDisplay = DOMCache.get(`#dvboxtime-${prayerName}`);
                    if (timeDisplay.length > 0) {
                        timeDisplay.text(newTime);
                    }
                }
            });

            console.log(`[PlayerDev] Prayer times updated for ${todayKey}`);

        } catch (error) {
            console.error('[PlayerDev] Error updating prayer times for new day:', error);
        }
    }

    // Main timer with better conflict prevention and date change detection
    function initMainTimer() {
        // Clear existing main timer
        TimerManager.clearInterval('mainTimer');

        let lastCheckedDate = getTodayKey();

        TimerManager.setInterval(() => {
            try {
                if (!PlayerDevModule.isInitialized) {
                    console.warn('[PlayerDev] Main timer running but module not initialized');
                    return;
                }

                const dt = new Date().toTimeString().split(" ")[0];
                const dthoursminute = dt.substring(0, 5);
                const dtseconds = dt.slice(-2);
                const lastSecond = dt.slice(-2);

                // Check for date change
                const currentDate = getTodayKey();
                if (currentDate !== lastCheckedDate) {
                    console.log(`[PlayerDev] Date changed from ${lastCheckedDate} to ${currentDate}`);
                    lastCheckedDate = currentDate;
                    updatePrayerTimesForNewDay();
                }

                // Update time display with existence check
                const timeElements = DOMCache.get('.time');
                if (timeElements.length > 0) {
                    timeElements.html(`<span>${dthoursminute}</span><span style="font-size:40%;">.${dtseconds}</span>`);
                }

                // Check events only every minute (when seconds = 00)
                if (lastSecond === '00') {
                    checkAndExecuteEvents();
                }

                // Update next adzan countdown
                updateNextAdzanCountdown();

            } catch (error) {
                console.error('[PlayerDev] Main timer error:', error);
                // Don't stop timer on error, but log it
            }
        }, 1000, 'mainTimer');
    }

    function checkAndExecuteEvents() {
        try {
            const eventData = eventChecker('#prayer');
            if (eventData && eventData.availableEvent) {
                if (typeof window[eventData.availableEvent] === 'function') {
                    console.log(`[PlayerDev] Executing event: ${eventData.availableEvent}`);
                    window[eventData.availableEvent](eventData);
                } else {
                    console.warn(`[PlayerDev] Event function not found: ${eventData.availableEvent}`);
                }
            }
        } catch (error) {
            console.error('[PlayerDev] Event checker error:', error);
        }
    }

    function updateNextAdzanCountdown() {
        if (PlayerDevModule.nextAdzanName !== '' && PlayerDevModule.nextAdzanTime) {
            try {
                const diffDisp = timeDistance(PlayerDevModule.nextAdzanTime);

                if (diffDisp > 0) {
                    const hours = Math.floor(diffDisp / (1000 * 60 * 60));
                    const minutes = Math.floor((diffDisp % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diffDisp % (1000 * 60)) / 1000);

                    const formattedHours = String(hours).padStart(2, '0');
                    const formattedMinutes = String(minutes).padStart(2, '0');
                    const formattedSeconds = String(seconds).padStart(2, '0');

                    const element = DOMCache.get(`#dvboxname-${PlayerDevModule.nextAdzanName}`);
                    if (element.length > 0) {
                        element.html(`${PlayerDevModule.nextAdzanName} <div><span> -${formattedHours}:${formattedMinutes}</span><span style="font-size:80%;">.${formattedSeconds}</span></div>`);
                    }
                } else {
                    // Time passed, reset
                    const nameElement = DOMCache.get(`#dvboxname-${PlayerDevModule.nextAdzanName}`);
                    const dataElement = DOMCache.get(`*[data-name="${PlayerDevModule.nextAdzanName}"]`);

                    if (nameElement.length > 0) {
                        nameElement.html(PlayerDevModule.nextAdzanName);
                    }
                    if (dataElement.length > 0) {
                        dataElement.removeClass('bg-grad-transparent').addClass('bg-grad-transparent');
                    }
                }
            } catch (error) {
                console.error('[PlayerDev] Next adzan countdown error:', error);
            }
        }
    }

    // Utility functions
    function isValidDate(date) {
        return date && Object.prototype.toString.call(date) === "[object Date]" && !isNaN(date);
    }

    function timeDistance(x) {
        const now = new Date().getTime();
        return x - now;
    }

    function _clearInterval(timerId) {
        if (timerId) {
            TimerManager.clearInterval(timerId);
        }
        // Use setTimeout to prevent direct recursion and reduce conflicts
        setTimeout(() => {
            if (PlayerDevModule.isInitialized) {
                eventInit();
            }
        }, 100);
    }

    function timeToDate(time) {
        try {
            if (!time || typeof time !== 'string') {
                console.warn('[PlayerDev] Invalid time format:', time);
                return new Date();
            }

            const now = new Date();
            const timeParts = time.split(":");

            if (timeParts.length >= 2) {
                const hours = parseInt(timeParts[0], 10);
                const minutes = parseInt(timeParts[1], 10);

                if (!isNaN(hours) && !isNaN(minutes)) {
                    now.setHours(hours, minutes, 0, 0);
                    return now;
                }
            }

            console.warn('[PlayerDev] Could not parse time:', time);
            return new Date();
        } catch (error) {
            console.error('[PlayerDev] timeToDate error:', error);
            return new Date();
        }
    }

    function minToMilisec(interval) {
        const result = Math.max(0, interval * 1000 * 60);
        return isNaN(result) ? 0 : result;
    }

    function countdownTimer(countdownTime, className) {
        if (!isValidDate(countdownTime)) {
            console.error('[PlayerDev] Invalid countdown time');
            return;
        }

        if (!className) {
            console.error('[PlayerDev] Invalid className for countdown');
            return;
        }

        const timerId = `countdown_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;

        TimerManager.setInterval(function () {
            try {
                const distance = timeDistance(countdownTime.getTime());

                if (distance < 1000) {
                    _clearInterval(timerId);
                    return;
                }

                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                const formattedMinutes = String(Math.max(0, minutes)).padStart(2, '0');
                const formattedSeconds = String(Math.max(0, seconds)).padStart(2, '0');

                const element = DOMCache.get(className);
                if (element.length > 0) {
                    element.html(`${formattedMinutes}:${formattedSeconds}`);
                }

            } catch (error) {
                console.error('[PlayerDev] Countdown timer error:', error);
                _clearInterval(timerId);
            }
        }, 1000, timerId);
    }

    function getPrayerData(elem) {
        try {
            if (!elem || !elem.data) {
                console.warn('[PlayerDev] Invalid element for getPrayerData');
                return null;
            }

            const now = new Date();
            const data = elem.data();

            // Validate required data
            if (!data.time || !data.name) {
                console.warn('[PlayerDev] Missing prayer data:', data);
                return null;
            }

            now.setSeconds(0, 0);
            data.datetime = timeToDate(data.time);

            // Calculate prayer times with validation
            data.beforeAdzanTime = new Date(data.datetime);
            data.beforeAdzanTime.setMinutes(data.beforeAdzanTime.getMinutes() - (parseInt(data.beforeAdzanInterval) || 5));

            data.adzanTime = new Date(data.datetime);
            data.adzanTime.setMinutes(data.datetime.getMinutes() + 2);

            data.iqamaTime = new Date(data.adzanTime);
            data.iqamaTime.setMinutes(data.iqamaTime.getMinutes() + (parseInt(data.iqamaInterval) || 5) - 2);

            data.afterPrayerTime = new Date(data.iqamaTime);
            data.afterPrayerTime.setMinutes(data.afterPrayerTime.getMinutes() + (parseInt(data.prayerInterval) || 5));

            data.fridayTime = null;
            data.isFriday = false;

            // Friday prayer handling
            if (now.getDay() === 5 && data.name === 'dzuhur') {
                data.name = "jumu'ah";
                data.fridayTime = new Date(data.datetime);
                if (PlayerDevModule.config && PlayerDevModule.config.interval && PlayerDevModule.config.interval.friday) {
                    data.fridayTime.setMinutes(PlayerDevModule.config.interval.friday + (parseInt(data.prayerInterval) || 5));
                }
                data.isFriday = true;
            }

            // Set global times
            if (data.name === 'subuh') { PlayerDevModule.SubuhTime = data.datetime; }
            if (data.name === 'isya') { PlayerDevModule.IsyaTime = data.datetime; }

            // Set next adzan
            if (now <= data.datetime && PlayerDevModule.nextAdzanName === '') {
                PlayerDevModule.nextAdzanName = data.name === "jumu'ah" ? "dzuhur" : data.name;
                PlayerDevModule.nextAdzanTime = data.datetime;

                const element = DOMCache.get(`*[data-name="${PlayerDevModule.nextAdzanName}"]`);
                if (element.length > 0) {
                    element.removeClass('bg-grad-transparent').addClass('bg-grad-transparent');
                }
            }

            // Determine available event
            if (data.name === 'syuruq' || data.name === 'imsak') {
                data.availableEvent = null;
            } else if (data.isFriday && now >= data.datetime && now < data.fridayTime) {
                data.availableEvent = 'isFridaySermon';
            } else if (now >= data.beforeAdzanTime && now < data.datetime) {
                data.availableEvent = 'isBeforeAdzan';
            } else if (now >= data.datetime && now < data.adzanTime) {
                data.availableEvent = 'isAdzanTime';
            } else if (now >= data.adzanTime && now < data.iqamaTime) {
                data.availableEvent = 'isBeforeIqama';
            } else if (now >= data.iqamaTime && now <= data.afterPrayerTime) {
                data.availableEvent = 'isSalah';
            } else {
                data.availableEvent = null;
            }

            return data;

        } catch (error) {
            console.error('[PlayerDev] getPrayerData error:', error);
            return null;
        }
    }

    function eventChecker(id) {
        try {
            const prayer = DOMCache.get(id);
            if (prayer.length === 0) {
                console.warn(`[PlayerDev] Prayer element not found: ${id}`);
                return null;
            }

            let eventData = null;

            prayer.children().each(function () {
                const data = getPrayerData($(this));
                if (data && data.availableEvent) {
                    eventData = data;
                    return false; // Break the loop
                }
            });

            return eventData;

        } catch (error) {
            console.error('[PlayerDev] eventChecker error:', error);
            return null;
        }
    }

    function hideAll() {
        try {
            const elements = DOMCache.get('.player-show');
            if (elements.length > 0) {
                elements.each(function () {
                    $(this).removeClass('player-show').addClass('player-hide');
                });
            }
        } catch (error) {
            console.error('[PlayerDev] hideAll error:', error);
        }
    }

    function timerExec(id, name, datetime) {
        try {
            const elem = DOMCache.get(id);
            if (elem.length === 0) {
                console.warn(`[PlayerDev] Timer exec element not found: ${id}`);
                return;
            }

            const nameElement = elem.find('.player-wrapper__name');
            if (nameElement.length > 0) {
                nameElement.html(name);
            }

            countdownTimer(datetime, '.player-wrapper__timer');
            hideAll();
            elem.removeClass('player-hide').addClass('player-show');
        } catch (error) {
            console.error('[PlayerDev] timerExec error:', error);
        }
    }

    // Prayer event handlers with global exposure
    window.isFridaySermon = function(data) {
        console.log('[PlayerDev] Friday sermon event');
        timerExec('#prayer-silent', data.name, data.fridayTime);
    };

    window.isBeforeAdzan = function(data) {
        console.log('[PlayerDev] Before adzan event');
        timerExec('#before-adzan', data.name, data.datetime);
    };

    window.isAdzanTime = function(data) {
        console.log('[PlayerDev] Adzan time event');
        timerExec('#adzan-time', data.name, data.adzanTime);
        try {
            const dataElement = DOMCache.get(`*[data-name="${PlayerDevModule.nextAdzanName}"]`);
            const nameElement = DOMCache.get(`#dvboxname-${PlayerDevModule.nextAdzanName}`);

            if (dataElement.length > 0) {
                dataElement.removeClass('bg-grad-transparent').addClass('bg-grad-transparent');
            }
            if (nameElement.length > 0) {
                nameElement.html(PlayerDevModule.nextAdzanName);
            }

            PlayerDevModule.nextAdzanName = '';
            PlayerDevModule.nextAdzanTime = '';
        } catch (error) {
            console.error('[PlayerDev] isAdzanTime error:', error);
        }
    };

    window.isBeforeIqama = function(data) {
        console.log('[PlayerDev] Before iqama event');
        timerExec('#iqama-time', data.name, data.iqamaTime);
    };

    window.isSalah = function(data) {
        console.log('[PlayerDev] Salah time event');
        timerExec('#prayer-silent', data.name, data.afterPrayerTime);
        // Note: isReloadPage removed as we no longer need page reload
        console.log('[PlayerDev] Prayer completed, continuing with normal operation');
    };

    function showExec(id, interval, show) {
        if (!show) {
            setTimeout(() => {
                if (PlayerDevModule.isInitialized) {
                    eventInit();
                }
            }, 100);
            return;
        }

        try {
            const elem = DOMCache.get(id);
            if (elem.length === 0) {
                console.warn(`[PlayerDev] Show exec element not found: ${id}`);
                setTimeout(() => {
                    if (PlayerDevModule.isInitialized) {
                        eventInit();
                    }
                }, 100);
                return;
            }

            const duration = minToMilisec(interval);
            const end = new Date().getTime() + duration;
            const timerId = `show_${id}_${Date.now()}`;

            hideAll();
            elem.removeClass('player-hide').addClass('player-show');

            TimerManager.setInterval(function () {
                const distance = timeDistance(end);
                if (distance < 1000) {
                    _clearInterval(timerId);
                }
            }, 1000, timerId);

        } catch (error) {
            console.error('[PlayerDev] showExec error:', error);
            setTimeout(() => {
                if (PlayerDevModule.isInitialized) {
                    eventInit();
                }
            }, 100);
        }
    }

    // Show functions with global exposure - removed location.reload
    window.showMain = function() {
        if (!PlayerDevModule.config) {
            console.warn('[PlayerDev] Config not initialized for showMain');
            return;
        }
        showExec('#main', PlayerDevModule.config.interval.main, PlayerDevModule.config.show.main);
        // Note: location.reload() removed - no longer needed with monthly data system
        console.log('[PlayerDev] Showing main display');
    };

    window.showLecture = function() {
        if (!PlayerDevModule.config) return;
        showExec('#lecture', PlayerDevModule.config.interval.lecture, PlayerDevModule.config.show.lecture);
    };

    window.showTransaction = function() {
        if (!PlayerDevModule.config) return;
        showExec('#transaction', PlayerDevModule.config.interval.transaction, PlayerDevModule.config.show.transaction);
    };

    window.showVideo = function() {
        if (!PlayerDevModule.config) return;
        showExec('#video', PlayerDevModule.config.interval.video, PlayerDevModule.config.show.video);
    };

    window.showImage = function() {
        if (!PlayerDevModule.config) return;
        showExec('#image', PlayerDevModule.config.interval.image, PlayerDevModule.config.show.image);
    };

    // Improved eventInit with better error handling
    const eventInit = () => {
        if (!PlayerDevModule.isInitialized) {
            console.warn('[PlayerDev] EventInit called but module not initialized');
            return;
        }

        const showFunc = [
            'showMain',
            'showLecture',
            'showTransaction',
            'showImage',
            'showVideo',
        ];

        const timerId = `eventInit_${Date.now()}`;

        TimerManager.setInterval(function () {
            try {
                TimerManager.clearInterval(timerId);

                const eventData = eventChecker('#prayer');

                if (eventData && eventData.availableEvent) {
                    if (typeof window[eventData.availableEvent] === 'function') {
                        window[eventData.availableEvent](eventData);
                    } else {
                        console.warn(`[PlayerDev] Event function not found: ${eventData.availableEvent}`);
                    }
                } else {
                    if (PlayerDevModule.showFuncReminder > 4) {
                        PlayerDevModule.showFuncReminder = 0;
                    }

                    const funcName = showFunc[PlayerDevModule.showFuncReminder++];
                    if (typeof window[funcName] === 'function') {
                        window[funcName]();
                    } else {
                        console.warn(`[PlayerDev] Show function not found: ${funcName}`);
                    }
                }

            } catch (error) {
                console.error('[PlayerDev] eventInit error:', error);
                TimerManager.clearInterval(timerId);
            }
        }, 1000, timerId);
    };

    // Main initialization function with global exposure
    window.playerInit = function(id, configInit) {
        try {
            console.log('[PlayerDev] Starting player initialization...');

            // Clear any existing timers and cache
            TimerManager.clearAll();
            DOMCache.clear();

            // Reset module state
            PlayerDevModule.showFuncReminder = 0;
            PlayerDevModule.nextAdzanName = '';
            PlayerDevModule.nextAdzanTime = null;
            PlayerDevModule.isReloadPage = 0; // Keep for compatibility but not used

            const prayer = DOMCache.get(id);
            if (prayer.length === 0) {
                console.error(`[PlayerDev] Prayer element not found: ${id}`);
                return;
            }

            PlayerDevModule.config = configInit;

            // Validate config
            if (!PlayerDevModule.config || !PlayerDevModule.config.show || !PlayerDevModule.config.interval) {
                console.error('[PlayerDev] Invalid config provided to playerInit');
                return;
            }

            // Initialize prayer display
            prayer.children().each(function () {
                const element = $(this);
                const name = element.data('name');
                const time = element.data('time');

                if (name && time) {
                    element.html(`
                        <div class="prayer-name" id="dvboxname-${name}">${name}</div>
                        <div class="prayer-time" id="dvboxtime-${name}">${time}</div>
                    `);
                }
            });

            // Mark as initialized
            PlayerDevModule.isInitialized = true;

            // Start main timer
            initMainTimer();

            // Start event loop
            eventInit();

            console.log('[PlayerDev] Player initialization completed successfully');

        } catch (error) {
            console.error('[PlayerDev] playerInit error:', error);
            PlayerDevModule.isInitialized = false;
        }
    };

    // Function to update prayer data when new monthly data is received
    window.updatePlayerPrayerData = function(newPrayerData) {
        try {
            console.log('[PlayerDev] Updating prayer data...');

            PlayerDevModule.monthlyPrayerData = newPrayerData;

            // Update current prayer times display
            updatePrayerTimesForNewDay();

            // Reset next adzan tracking to recalculate with new times
            PlayerDevModule.nextAdzanName = '';
            PlayerDevModule.nextAdzanTime = null;

            console.log('[PlayerDev] Prayer data updated successfully');

        } catch (error) {
            console.error('[PlayerDev] Error updating prayer data:', error);
        }
    };

    // Function to get current prayer status (for debugging)
    window.getPlayerStatus = function() {
        return {
            isInitialized: PlayerDevModule.isInitialized,
            nextAdzanName: PlayerDevModule.nextAdzanName,
            nextAdzanTime: PlayerDevModule.nextAdzanTime,
            activeTimers: TimerManager.getActiveTimers(),
            config: PlayerDevModule.config,
            todayKey: getTodayKey()
        };
    };

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        console.log('[PlayerDev] Page unloading, cleaning up...');
        PlayerDevModule.isInitialized = false;
        TimerManager.clearAll();
        DOMCache.clear();
    });

    // Global error handler
    window.addEventListener('error', function(e) {
        console.error('[PlayerDev] Global error:', e.error);
    });

    console.log('[PlayerDev] Monthly Prayer Data Compatible Module loaded successfully');

})();
