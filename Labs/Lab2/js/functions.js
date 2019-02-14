var randomNumber = Math.floor(Math.random() * 99) + 1;
var guesses = document.querySelector('#guesses');
var lastResult = document.querySelector('#lastResult');
var lowOrHigh = document.querySelector('#lowOrHigh');
var guessSubmit = document.querySelector('.guessSubmit');
var guessField = document.querySelector('.guessField');
var resetButton = document.querySelector('#reset');
var guessCount = 1;
var numberOfWins = 0;
var numberOfLosses = 0;
var winsLosses = document.querySelector('#winsLosses');
var resetButton;


guessField.focus();
resetButton.style.display = 'none';
winsLosses.innerHTML = 'Wins: ' + numberOfWins + ' Losses: ' + numberOfLosses;
            
function checkGuess() {
    var userGuess = Number(guessField.value);
    if (userGuess < 0 || userGuess > 99 || !Number.isInteger(userGuess)) {
        alert('Invalid guess! Try again.');
        guessField.value = '';
    }
    else {
                    
        if (guessCount === 1) {
            guesses.innerHTML = 'Previous guesses: ';
        }
        guesses.innerHTML += userGuess + ' ';
                    
        if (userGuess === randomNumber) {
            lastResult.innerHTML = 'Congratulations! You got it right!';
            lastResult.style.backgroundColor = 'green';
            lowOrHigh.innerHTML = '';
            setGameOver();
        }
        else if (guessCount === 7) {
            lastResult.innerHTML = 'Sorry, you lost!';
            setGameOver();
        }
        else {
            lastResult.innerHTML = 'Wrong!';
            lastResult.style.backgroundColor = 'red';
            if (userGuess < randomNumber) {
                lowOrHigh.innerHTML = 'Last guess was too low!';
            }
            else if (userGuess > randomNumber) {
                lowOrHigh.innerHTML = 'Last guess was too high!';
            }
        }
                    
        guessCount++;
        guessField.value = '';
        guessField.focus();
    }
}
            
guessSubmit.addEventListener('click', checkGuess);
            
function setGameOver() {
    guessField.disabled = true;
    guessSubmit.disabled = true;
    resetButton.style.display = 'inline';
    resetButton.addEventListener('click', resetGame);
    if (lastResult.innerHTML === 'Sorry, you lost!') {
        numberOfLosses++;
    }
    else {
        numberOfWins++;
    }
    winsLosses.innerHTML = 'Wins: ' + numberOfWins + ' Losses: ' + numberOfLosses;
}
            
function resetGame() {
    guessCount = 1;
                
    var resetParas = document.querySelectorAll('.resetParas p');
    for (var i = 0; i < resetParas.length; i++) {
        resetParas[i].textContent = '';
    }
                
    resetButton.style.display = 'none';
                
    guessField.disabled = false;
    guessSubmit.disabled = false;
    guessField.value = '';
    guessField.focus();
                
    lastResult.style.backgroundColor = 'white';
                
    randomNumber = Math.floor(Math.random() * 99) + 1;
    winsLosses.innerHTML = 'Wins: ' + numberOfWins + ' Losses: ' + numberOfLosses;
}