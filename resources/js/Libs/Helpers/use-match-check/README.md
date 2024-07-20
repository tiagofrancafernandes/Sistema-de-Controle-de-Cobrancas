# Match Check

#### Usage

```js
// import useMatchCheck from '../use-match-check';

useMatchCheck([
    [[1, 4, 5], 'opt 1'],
    [[3, 9], 'opt 2'],
])(3), // opt 2

useMatchCheck({1: 1, 4: 4, 5: 5, 3: 3})(30), // null
useMatchCheck({1: 1, 4: 4, 5: 5, 3: 3}, 'default value')(30), // default value
useMatchCheck({1: 1, 4: 4, 5: 5, 3: 3})(30, 'default value inline'), // default value inline
useMatchCheck({1: 1, 4: 4, 5: 5, 3: 3}, 'default value')(30, 'default value inline'), // padrao inline

```

### Reusable

```js

// Resuse the same check
let check1 = useMatchCheck([
    [
      [1, 4, 5], 'Great! is 1, 4 or 5'
    ],
    [
      [3, 9, 50], 'Great! is 3, 9 or 50'
    ],
    [
      [30, 90], 'Great! is 30 or 90'
    ],
]);

check1(30), // Great! is 30 or 90

// Reusable
let anotherCheck = useMatchCheck({1: 1, 4: 4, 5: 5, 3: 3}, 'default value');

anotherCheck(3), // 3
anotherCheck(30), // default value
anotherCheck(30, 'another default value'), // another default value
```
