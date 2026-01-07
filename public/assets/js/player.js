var config;
var showFuncReminder = 0;
var nextAdzanName = '';
var nextAdzanTime;
var SubuhTime;
var IsyaTime;
var data;
var isReloadPage=0;

function openFullscreen(elem) {

    if (elem.requestFullscreen)
        elem.requestFullscreen();

    else if (elem.webkitRequestFullscreen)
        elem.webkitRequestFullscreen();

    else if (elem.msRequestFullscreen)
        elem.msRequestFullscreen();

    $('#full-screen-modal').modal('hide');
}

setInterval(() => {
    let dt = new Date().toTimeString().split(" ")[0];
    let dthoursminute = dt.substring(0,5);
    let dtseconds = dt.slice(-2);

    var lastSecond = dt.slice(-2);
    if(lastSecond=='00'){
        let eventData = eventChecker('#prayer');
        if (eventData && eventData.availableEvent) {
            window[eventData.availableEvent](eventData);
        }
        //console.log(eventData.availableEvent);
    }
    //console.log(nextAdzanName);

    if(nextAdzanName!==''){
        let diffDisp = timeDistance(nextAdzanTime);

        let hours = Math.floor(diffDisp / 1000 / 60 / 60);
        let minutes = Math.floor((diffDisp % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((diffDisp % (1000 * 60)) / 1000);

        if(hours>=0 && minutes >=0 && seconds>=0){
            hours = String(hours).padStart(2, '0');
            minutes = String(minutes).padStart(2, '0');
            seconds = String(seconds).padStart(2, '0');
            $('#dvboxname-'+nextAdzanName).html(nextAdzanName + ' <div><span> -' + hours + ':' + minutes +'</span><span style="font-size:80%;">.'+ seconds + '</span></div>');
        }else{
            $('#dvboxname-'+nextAdzanName).html(nextAdzanName );
            $('*[data-name="' + nextAdzanName + '"]').removeClass('bg-grad-transparent').addClass('bg-grad-transparent');
        }
    }

    //console.log(isReloadPage);

    //console.log(lastSecond);
    $('.time').html('<span>' + dthoursminute + '</span><span style="font-size:40%;">.' + dtseconds + '</span>');
}, 1000);

function isValidDate(date) {
    return date && Object.prototype.toString.call(date) === "[object Date]" && !isNaN(date);
}

function timeDistance(x) {
    let now = new Date().getTime();

    return x - now
}

function _clearInterval(x) {
    clearInterval(x);
    eventInit();
}

function timeToDate(time) {
    let now = new Date();
    now.setHours(time.split(":")[0], time.split(":")[1], 0, 0);

    return now;
}

function minToMilisec(interval) {
    return (interval * 1000 * 60);
}

function countdownTimer(countdownTime, className) {

    let x = setInterval(function () {
        let distance = timeDistance(countdownTime.getTime());
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        minutes = String(minutes).padStart(2, '0');
        seconds = String(seconds).padStart(2, '0');
        $(className).html(minutes +':'+ seconds);

        if (distance < 1000)
            _clearInterval(x);

    }, 1000);
}

function getPrayerData(elem) {
    let now = new Date();
    let data = elem.data();

    now.setSeconds(0, 0);
    data.datetime = timeToDate(data.time);

    data.beforeAdzanTime = new Date(data.datetime);
    data.beforeAdzanTime.setMinutes(data.beforeAdzanTime.getMinutes() - data.beforeAdzanInterval);

    data.adzanTime = new Date(data.datetime);
    data.adzanTime.setMinutes(data.datetime.getMinutes() + 2);

    data.iqamaTime = new Date(data.adzanTime);
    data.iqamaTime.setMinutes(data.iqamaTime.getMinutes() + data.iqamaInterval - 2);

    data.afterPrayerTime = new Date(data.iqamaTime);
    data.afterPrayerTime.setMinutes(data.afterPrayerTime.getMinutes() + data.prayerInterval);

    data.fridayTime = null;
    data.isFriday = false;

    if (now.getDay() == 5 && data.name === 'dzuhur') {
        data.name = "jumu'ah";
        data.fridayTime = new Date(data.datetime);
        data.fridayTime.setMinutes(config.interval.friday + data.prayerInterval)
        data.isFriday = true;
    }

    if(data.name=='subuh'){SubuhTime = data.datetime}
    if(data.name=='isya'){IsyaTime = data.datetime}

    //if(data.name!=='isya'){
        if(now<= data.datetime && nextAdzanName==''){
            if(data.name=="jumu'ah"){
                nextAdzanName = "dzuhur";
            }else{
                nextAdzanName = data.name;
            }
            nextAdzanTime = data.datetime;

            $('*[data-name="' + nextAdzanName + '"]').removeClass('bg-grad-transparent').addClass('bg-grad-transparent');
        }
    //}



    if (data.name === 'syuruq' || data.name === 'imsak')
        data.availableEvent = null;

    else if (data.isFriday && now >= data.datetime && now < data.fridayTime)
        data.availableEvent = 'isFridaySermon';

    else if (now>= data.beforeAdzanTime && now< data.datetime)
        data.availableEvent = 'isBeforeAdzan';

    else if (now>= data.datetime && now< data.adzanTime )
        data.availableEvent = 'isAdzanTime';

    else if (now>= data.adzanTime && now< data.iqamaTime )
        data.availableEvent = 'isBeforeIqama';

    else if (now>= data.iqamaTime && now<= data.afterPrayerTime)
        data.availableEvent = 'isSalah';

    else
        data.availableEvent = null;

    //console.log(data.availableEvent);
    return data;
};

function eventChecker(id) {
    let prayer = $(id);

    prayer.children().each(function () {
        data = getPrayerData($(this));

        return !(data.availableEvent);
    });

    if (data.availableEvent)
        return data;

    return false;
}


function hideAll() {
    $('.player-show').each(function () {
        $(this).removeClass('player-show').addClass('player-hide');
    });
}

function timerExec(id, name, datetime) {
    let elem = $(id);
    elem.find('.player-wrapper__name').html(name);
    countdownTimer(datetime, '.player-wrapper__timer');
    hideAll();
    elem.removeClass('player-hide').addClass('player-show');
}

function isFridaySermon(data) {
    timerExec('#prayer-silent', data.name, data.fridayTime);
}

function isBeforeAdzan(data) {
    timerExec('#before-adzan', data.name, data.datetime);
}

function isAdzanTime(data) {
    timerExec('#adzan-time', data.name, data.adzanTime);
    $('*[data-name="' + nextAdzanName + '"]').removeClass('bg-grad-transparent').addClass('bg-grad-transparent');
    $('#dvboxname-'+nextAdzanName).html(nextAdzanName);
    nextAdzanName='';
    nextAdzanTime='';
}

function isBeforeIqama(data)  {
    timerExec('#iqama-time', data.name, data.iqamaTime);
}

function isSalah(data) {
    timerExec('#prayer-silent', data.name, data.afterPrayerTime);
    isReloadPage = 1;
}

function showExec(id, interval, show) {
    if (show) {
        let elem = $(id);
        let end = new Date().getTime() + minToMilisec(interval);

        hideAll();
        elem.removeClass('player-hide').addClass('player-show');

        let x = setInterval(function () {
            let distance = timeDistance(end);

            if (distance < 1000)
                _clearInterval(x);
        }, 1000);
    } else {
        eventInit();
    }
}

function showMain() {
    showExec('#main', config.interval.main, config.show.main);
    if(isReloadPage==1){
        location.reload();
    }
}

function showLecture() {
    showExec('#lecture', config.interval.lecture, config.show.lecture);
}

function showTransaction() {
    showExec('#transaction', config.interval.transaction, config.show.transaction);
}

function showVideo() {
    showExec('#video', config.interval.video, config.show.video);
}

function showImage() {
    showExec('#image', config.interval.image, config.show.image);
}

const eventInit = () => {
    let showFunc = [
        'showMain',
        'showLecture',
        'showTransaction',
        'showImage',
        'showVideo',
    ];

    let x = setInterval(function () {
        let eventData = eventChecker('#prayer');
        clearInterval(x);

        if (eventData && eventData.availableEvent) {
            let eventData = eventChecker('#prayer');
            window[eventData.availableEvent](eventData);
        }else{
            if (showFuncReminder > 4) {
                showFuncReminder = 0;
            }
            window[showFunc[showFuncReminder++]]();

        }
        //eventInit();

    }, 1000);

}

function playerInit(id, configInit) {
    let prayer = $(id);
    config = configInit;

    prayer.children().each(function () {
        $(this).html('<div class=prayer-name id="dvboxname-'+ $(this).data('name') +'">'+ $(this).data('name') +'</div><div class=prayer-time id="dvboxtime-'+ $(this).data('name') +'">'+ $(this).data('time') +'</div>');
    });

    eventInit();
}


