export const toBool = (value) => {
    if (!isNaN(parseFloat(value))) {
        return Boolean(parseFloat(value));
    }

    if (!value) {
        return Boolean(value);
    }

    let type = typeof value;

    type = `${type}`.toLowerCase();

    if (type === 'boolean') {
        return value;
    }

    let values = {
        'no': false,
        'nao': false,
        'false': false,
        'f': false,
        'não': false,
        'n': false,
        '0': false,
        0: false,

        'yes': true,
        'sim': true,
        'true': true,
        't': true,
        's': true,
        '1': true,
        1: true,
    };

    if (type in values || value in values) {
        return values[type];
    }

    return Boolean(value);
}
