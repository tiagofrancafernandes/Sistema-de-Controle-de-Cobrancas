export const isAFunction = (value) => {
    if (!value || typeof value !== 'function') {
        return false;
    }

    return typeof value === 'function';
}

export const functionOr = (fn) => {
    return isAFunction(fn) ? fn : (...args) => null;
}

export const tryRun = (fn, args = [], catcher = null) => {
    if (!isAFunction(fn)) {
        return null;
    }

    if (!Array.isArray(args) && catcher === null) {
        args = [args];
    }

    args = Array.isArray(args) ? args : [];

    catcher = functionOr(catcher);

    try {
        return fn(...args);
    } catch (error) {
        return catcher(...args);
    }
}

export const callFuncion = (fn, ...args) => tryRun(fn, args);
export const evaluateFn = (fn, ...args) => tryRun(fn, args);
export const evaluateOrValue = (fn, ...args) => {
    if (!isAFunction(fn)) {
        return fn;
    }

    return evaluateFn(fn, args);
};
export const wrapFn = (value, ...args) => {
    if (!isAFunction(value)) {
        return () => value;
    }

    return (...args) => tryRun(value, args);
}
export const tryRunOr = (fn, args = [], defaultValue = null) => {
    if (!Array.isArray(args) && defaultValue === null) {
        defaultValue = args;
        args = [];
    }

    return tryRun(fn, args, () => defaultValue);
};

export const waitFor = (milliseconds) => {
    milliseconds = !isNaN(parseInt(milliseconds)) ? parseInt(milliseconds) : 0;
    return new Promise(resolve => {
        setTimeout(resolve, milliseconds);
    });
}

export const callFunctionAfter = async (fn, args = [], after = null) => {
    if (!Array.isArray(args) && after === null) {
        after = !isNaN(parseInt(args)) ? parseInt(args) : null;
        args = [];
    }

    after = parseInt(after);

    if (isNaN(after) || after < 0) {
        return;
    }

    await waitFor(after);

    return tryRun(fn, args);
}

export const repeatFnFor = async (fn, times = 1, interval = 0) => {
    times = !isNaN(parseInt(times)) ? parseInt(times) : 0;
    interval = !isNaN(parseInt(interval)) ? parseInt(interval) : 0;

    times = times < 0 ? 0 : times;
    interval = interval < 0 ? 0 : interval;
    let incNum = 0;

    for(;incNum <= times;) {
        await waitFor(interval);
        incNum++;
        tryRun(fn, [incNum]);
    }
}

export const valueToType = (value, type) => {
    type = typeof type === 'string' ? type.trim().toLowerCase() : null;
    let valueType = typeof value;

    if (!type) {
        return value;
    }

    if (!['string', 'boolean', 'number', 'function', 'array', 'object', 'null'].includes(type)) {
        return value;
    }

    if (valueType === type) {
        return value;
    }

    switch (type) {
        case 'string':
            return valueType === 'object' && valueType?.toString ? valueType?.toString() : `${value}`;
            break;

        case 'boolean':
            return valueType === 'boolean' ? value : ((_value) => {
                _value = typeof _value === 'string' ? _value.trim().toLowerCase() : _value;
                return !['false', '0', '', '!true', 'no', false, 0, undefined, null].includes(_value);
            })(value);
            break;

        case 'number':
            return isNaN(parseFloat(value)) ? 0 : (value - 0.0);
            break;

        case 'function':
            return wrapFn(value);
            break;

        case 'array':
            return Array.isArray(value) ? value : (valueType === 'object' ? Object.values(value) : [value])
            break;

        case 'object':
            return valueType === 'object' ? value : { value };
            break;

        case 'null':
            return null;
            break;

        default:
            return value;
            break;
    }

    return value;
}

export const putGlobalFunction = (name, fn, globalObject = null, replace = false, prefix = '') => {
    if (!globalObject || typeof globalObject !== 'object' || Array.isArray(globalObject)) {
        return;
    }

    name = name && typeof name === 'string' ? name.trim() : null;
    prefix = prefix && typeof prefix === 'string' ? prefix.trim() : '';

    if (!name || !(isAFunction(fn) || typeof fn === 'object')) {
        return;
    }

    if (!replace && (name in globalObject)) {
        return;
    }

    if (replace && (name in globalObject)) {
        console.log(`Replacing '${name}' in %s`, (globalObject?.constructor?.name ?? 'a globalObject'));
    }

    name = `${prefix}${name}`;

    globalObject[name] = fn;
}

export const pushGlobalFunctions = (functions, globalObject = null, replace = false, prefix = '') => {
    if (!functions || typeof functions !== 'object' || Array.isArray(functions)) {
        return;
    }

    globalObject = globalObject ?? window;

    if (!globalObject || typeof globalObject !== 'object' || Array.isArray(globalObject)) {
        return;
    }

    for (let [name, fn] of Object.entries(functions)) {
        putGlobalFunction(name, fn, globalObject, replace, prefix);
    }
}
