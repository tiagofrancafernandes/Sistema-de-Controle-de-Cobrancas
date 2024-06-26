import { sizeIsValid, validCssSize } from '@/Libs/Helpers/CssHelpers';

const noSizeProperties = [
    //
];

export const propertyCanBeResize = (property) => {
    return !(noSizeProperties.includes(property) || noSizeProperties.includes(realPropertyName(property)));
}

export const realPropertyName = (property) => {
    if (!property || !['string', 'number'].includes(typeof property)) {
        return null;
    }

    property = property.trim().toLowerCase();

    if (!property) {
        return null;
    }

    property = property.slice(property.lastIndexOf(':')+1);

    return property.slice(0, (property.indexOf('-')));
}

export const validPropertySize = (property, size = null, defaultSize = 'md') => {
    if (!property || !['string', 'number'].includes(typeof property)) {
        return null;
    }

    if (size === true) {
        size = defaultSize;
    }

    size = `${size}`.trim().toLowerCase();
    property = property.trim().toLowerCase();

    if (!propertyCanBeResize(property)) {
        return property;
    }

    if ([0, '0'].includes(size)) {
        return `${property}-0`;
    }

    if ([''].includes(size)) {
        return property;
    }

    if (!size || [false, 'false', '!true', 'none', 'no'].includes(size)) {
        return `${property}-none`;
    }

    if (
        [
            'xs',
            'sm',
            'md',
            'lg',
            'xl',
            'xxl',
            'large',
            'x-large',
            'full',
        ].includes(size)
    ) {
        return `${property}-${size}`;
    }

    if (sizeIsValid(size)) {
        return sprintf(`${property}-[%s]`, validCssSize(size))
    }

    if (!isNaN(parseFloat(size))) {
        return parseFloat(size) < 0 ? `-${property}${size}` : `${property}-${size}`;
    }

    return property;
}

export const roundedProperty = (rounded = true, defaultSize = 'md') => {
    return validPropertySize('rounded', rounded, defaultSize);
}

export const lightAndDarkProperty = (light, dark = null, asString = false) => {
    dark = dark ?? light;
    light = ['object', 'string'].includes(typeof light) ? light : null;
    dark = ['object', 'string'].includes(typeof dark) ? dark : null;
    light = Array.isArray(light) ? light : [light];
    dark = Array.isArray(dark) ? dark : [dark];
    light = validPropertySize(...light);
    dark = validPropertySize(...dark);
    dark = dark ? `dark:${dark}` : null;

    if (asString) {
        return [light, dark,].filter(item => item).join(' ');
    }

    return {
        light,
        dark,
    }
}

export const getPresetClasses = (color, presets, defaultColor = null) => {
    color = color ?? defaultColor;

    if (typeof color !== 'string' || !color.trim()) {
        return {};
    }

    color = color.trim();

    if (!presets || typeof color !== 'object' || Array.isArray(presets)) {
        return {};
    }

    return color in presets ? presets[color] : {};
}
