
    function increment() {
    let counterInput = document.getElementById("counterInput");
    let numberInput = document.getElementById("numberInput");
    let value = parseInt(counterInput.value);
    
    if (value < 99) {
    value++;
    counterInput.value = value;
    numberInput.value = value;
    }
    }
    
    function decrement() {
    let counterInput = document.getElementById("counterInput");
    let numberInput = document.getElementById("numberInput");
    let value = parseInt(counterInput.value);
    
    if (value > 1) {
    value--;
    counterInput.value = value;
    numberInput.value = value;
    }
    }

