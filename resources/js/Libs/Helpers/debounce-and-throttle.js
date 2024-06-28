import { isAFunction, tryRun } from '@/Libs/Helpers/FunctionHelpers';

// https://blog.logrocket.com/debounce-throttle-vue/

export function throttle(fn, wait) {
    if (!isAFunction(fn)) {
        throw `The 'fn' param must be a valid function`;
    }

    wait = parseInt(wait);

    if (isNaN(wait) || wait < 0) {
        throw `The 'wait' param must be a positive number`;
    }

    let throttled = false;
    return function(...args){
        if(!throttled){
            fn.apply(this,args);
            throttled = true;
            setTimeout(()=>{
                throttled = false;
            }, wait);
        }
    }
}

export function debounce(fn, wait = 250) {
    if (!isAFunction(fn)) {
        throw `The 'fn' param must be a valid function`;
    }

    wait = parseInt(wait);

    if (isNaN(wait) || wait < 0) {
        throw `The 'wait' param must be a positive number`;
    }

    let timer;
    return function(...args){
        if(timer) {
            clearTimeout(timer); // clear any pre-existing timer
        }
        const context = this; // get the current context
        timer = setTimeout(()=>{
            fn.apply(context, args); // call the function if time expires
        }, wait);
    }
}

/*
// Usage
debouncedEventHandler = debounce((event) => {
    console.log('changed value:', event.target.value);
    // call fetch API to get results
}, 500); // 500 ms

// On HTML
// v-on:keydown="debouncedEventHandler"
// v-on:keyup="debouncedEventHandler"
// v-on:change="debouncedEventHandler"
*/

// Another example
/*
const onChangeSearch = debounce((event) => {
    console.log('changed value:', event?.target?.value, {event});
    // call fetch API to get results

    let searchValue = search.value;
    let urlQuery = searchValue ? `?search=${search.value}` : '';
    let url = `/dev/crud/index/v2${urlQuery}`;

    router.visit(url, {
        only: ['pageData'],
        // except: ['pageData'],
    });
}, 500);
*/
