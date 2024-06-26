export const sizeIsValid = (value) => {
    value = value && typeof value === 'string' ? value : '';

    return (new RegExp(/^([0-9]){0,}([\.])?([0-9]){1,}(px|em|rem)$/ig)).test(value);
}

export const validCssSize = (size, orValue = null) => {
    if (sizeIsValid(size)) {
        return size;
    }

    return orValue && typeof orValue === 'string' ? orValue : null;
}

export const validClassMerge = (...params) => {
    let classes = [];

    params = params
        .filter(item => item && ['object', 'string'].includes(typeof item));

    params.forEach(value => {
        if (typeof value === 'string') {
            classes.push(value);
            return;
        }

        if (typeof value !== 'object') {
            return;
        }

        if (Array.isArray(value)) {
            value = value.filter(item => item && (typeof item === 'string') && item.trim())
                .map(item => item.trim());

            classes.push(...value);
            return;
        }

        classes.push(...(
            Object.keys(Object.fromEntries(Object.entries(value).filter(([value, expr]) => expr)))
        ));
        return;
    });

    return [...new Set(classes || [])];
}
