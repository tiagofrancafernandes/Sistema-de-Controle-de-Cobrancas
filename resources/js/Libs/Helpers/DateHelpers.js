import { isAFunction, tryRun } from '@/Libs/Helpers/FunctionHelpers';

export const tryDate = (value, catcher = null) => {
    try {
        value = ['object', 'string', 'number'].includes(typeof value) ? value : null;

        if (value === null) {
            return null;
        }

        value = ['string', 'number'].includes(typeof value) ? new Date(value) : value;

        value = value?.constructor?.name === 'Date' && value?.toString() !== 'Invalid Date' ? value : null;

        return value ? value : null;

    } catch (error) {
        catcher = isAFunction(catcher) ? catcher : null;

        tryRun(catcher, error);

        return null;
    }
}

export const asDate = (value) => {
    return tryDate(value, (err) => console.log(err)) || null;
}

export const formatDate = (date, format = null) => {
    format = typeof format === 'string' ? format : 'iso';
    date = asDate(date, null);

    if (!date) {
        return null;
    }

    if (format === 'Date') {
        return date;
    }

    const iso = (d) => d.toISOString();
    const json = (d) => d.toJSON();
    const str = (d) => d.toString();
    const UTCString = (d) => d.toUTCString();
    const TimeString = (d) => d.toTimeString();
    const unixTime = (d) => d.getTime();
    const localeDate = (d) => d.toLocaleDateString();
    const localeTime = (d) => d.toLocaleTimeString();
    const locale = (d) => d.toLocaleString();

    const presets = {
        c: iso,
        iso,
        json,
        str,
        UTCString,
        TimeString,
        unixTime,
        utime: unixTime,
        toTime: unixTime,
        unix: unixTime,
        localeDate,
        localeTime,
        unixTime,
        locale,
        local: locale,
        localDate: locale,
        localDateTime: locale,
    }

    if (format in date) {
        let dateItem = date[format] ?? null;
        return isAFunction(dateItem) ? tryRun(() => date[format]()) : tryRun(() => date[format]);
    }

    if (format.toLowerCase() in presets) {
        return tryRun(presets[format.toLowerCase()], [date]);
    }

    format = ['date:br', 'br', 'pt-br', 'brazil', 'br-time'].includes(format.toLowerCase()) ? 'd/m/Y H:i' : format;
    format = ['date:us', 'us', 'en-us', 'usa', 'us-time'].includes(format.toLowerCase()) ? 'm/d/Y H:i' : format;
    format = ['basic', 'datetime', 'date time'].includes(format) ? 'Y-m-d H:i:s' : format;
    format = ['date'].includes(format) ? 'Y-m-d' : format;
    format = ['hour', 'time'].includes(format) ? 'H:i:s' : format;

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    const dateInfo = {
        Y: year,
        y: String(date.getFullYear()).slice(2),
        m: month,
        d: day,
        H: hours,
        i: minutes,
        s: seconds,
        c: iso(date),
    }

    return format.split('').map(char => {
        return char = char in dateInfo ? dateInfo[char] : char;
    }).join('');
}
