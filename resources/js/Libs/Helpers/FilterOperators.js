import {toTitle} from '@/Libs/Helpers/StringHelpers';

export const operatorList = {
    get LT() {
        return {
            value: 'lt',
            name: 'LT',
            ref: '<',
            label: 'less than',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    get LE() {
        return {
            value: 'le',
            name: 'LE',
            ref: '<=',
            label: 'less or equal',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    get EQ() {
        return {
            value: 'eq',
            name: 'EQ',
            ref: '==',
            label: 'equal',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    get GT() {
        return {
            value: 'gt',
            name: 'GT',
            ref: '>',
            label: 'greater than',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    get GE() {
        return {
            value: 'ge',
            name: 'GE',
            ref: '>=',
            label: 'greater or equal',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    get NE() {
        return {
            value: 'ne',
            name: 'NE',
            ref: '!=',
            label: 'does not equal',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    get SW() {
        return {
            value: 'sw',
            name: 'SW',
            ref: '%...',
            label: 'starts with',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    get NSW() {
        return {
            value: 'nsw',
            name: 'NSW',
            ref: '',
            label: 'does not start with',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    get EW() {
        return {
            value: 'ew',
            name: 'EW',
            ref: '...%',
            label: 'ends with',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    get NEW() {
        return {
            value: 'new',
            name: 'NEW',
            ref: '',
            label: 'does not end with',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    /*
    get BT() { // TODO
        return {
            value: 'bt',
            name: 'BT',
            ref: '[a, b]',
            label: 'between',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    */
    get CT() {
        return {
            value: 'ct',
            name: 'CT',
            ref: '%...%',
            label: 'contains',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    get NC() {
        return {
            value: 'nc',
            name: 'NC',
            ref: '',
            label: 'does not contains',
            toJson() {
                return JSON.stringify(this);
            },
            toString() {
                return this.value;
            },
        };
    },
    list() {
        return {
            LT: this.LT,
            LE: this.LE,
            EQ: this.EQ,
            GT: this.GT,
            GE: this.GE,
            NE: this.NE,
            SW: this.SW,
            NSW: this.NSW,
            EW: this.EW,
            NEW: this.NEW,
            // BT: this.BT, // TODO
            CT: this.CT,
            NC: this.NC,
        };
    },
    tryFrom(value) {
        value = typeof value === 'string' ? value.trim().toUpperCase() : null;

        if (!value) {
            return null;
        }

        let list = this.list() || {};

        return (value in list) ? list[value] : null;
    },
    toJson() {
        return JSON.stringify(this.list());
    },
    toString() {
        return this.toJson();
    },
    asOptionList(withRef = false) {
        return Object.fromEntries(Object.values(this.list()).map(item => [item.value, toTitle(item.label) + (withRef && item.ref ? ` ${item.ref}` : '')]));
    },
}

export const LT = operatorList.LT; // less than
export const LE = operatorList.LE; // less or equal
export const EQ = operatorList.EQ; // equal
export const GT = operatorList.GT; // greater than
export const GE = operatorList.GE; // greater or equal
export const NE = operatorList.NE; // Does not equal
export const SW = operatorList.SW; // starts with
export const NSW = operatorList.NSW; // Does not start with
export const EW = operatorList.EW; // ends with
export const NEW = operatorList.NEW; // Does not end with
// export const BT = operatorList.BT; // between // TODO
export const CT = operatorList.CT; // contains
export const NC = operatorList.NC; // Does not contains

export const asOptionList = operatorList.asOptionList;
