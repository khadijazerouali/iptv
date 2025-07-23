function increment() {
    const counterInput = document.getElementById('counterInput');
    let currentValue = parseInt(counterInput.value);
    if (currentValue < parseInt(counterInput.max)) {
        counterInput.value = currentValue + 1;
    }
}

function decrement() {
    const counterInput = document.getElementById('counterInput');
    let currentValue = parseInt(counterInput.value);
    if (currentValue > parseInt(counterInput.min)) {
        counterInput.value = currentValue - 1;
    }
}
