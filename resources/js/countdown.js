if (document.querySelector(".countdown-digital") !== null) {

    // count-down timer
    let countdown_time = parseInt(document.querySelector('#countdown_time').value);
    let now = new Date().getTime();
    let dest = now + countdown_time * 1000;

    let x = setInterval(function () {
        let now = new Date().getTime();
        let diff = dest - now;
        
        // Check if the countdown has reached zero or negative
        if (diff <= 0) {
            clearInterval(x); // Stop the countdown 
            document.querySelector('.quiz-action-btn').style.display = 'block';
            document.querySelector('.timer').style.display = 'none';

            // giveaway alert + reload
            if (document.querySelector('#countdown_page_reload')) {
                window.location.reload();
            }
            return; // Exit the function
        }
        
        let days = Math.floor(diff / (1000 * 60 * 60 * 24));
        let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((diff % (1000 * 60)) / 1000);


        
        if (days < 10) {
            days = `0${days}`;
        }
        if (hours < 10) {
            hours = `0${hours}`;
        }
        if (minutes < 10) {
            minutes = `0${minutes}`;
        }
        if (seconds < 10) {
            seconds = `0${seconds}`;
        }
        
        // Get elements by class name
        let countdownElements = document.getElementsByClassName("countdown-element");
        
        // Loop through the elements and update their content
        for (let i = 0; i < countdownElements.length; i++) {
        let className = countdownElements[i].classList[1]; // Get the second class name
        switch (className) {
            case "days":
                countdownElements[i].parentElement.style.display = days ? 'block' : 'none';
                countdownElements[i].innerHTML = days;
                break;
            case "hours":
                countdownElements[i].parentElement.style.display = parseInt(hours) > 0 ? 'block' : 'none';
                countdownElements[i].innerHTML = hours;
                break;
            case "minutes":
                countdownElements[i].parentElement.style.display = parseInt(minutes) > 0 ? 'block' : 'none';
                countdownElements[i].innerHTML = minutes;
                break;
            case "seconds":
                countdownElements[i].parentElement.style.display = 'block';
                countdownElements[i].innerHTML = seconds;
                break;
            default:
                break;
            }
        }
    }, 1000);

    setInterval(() => {
        window.location.reload()
    }, 55 * 1000); // reload page each 55 sec
}
if (document.querySelector(".countdown-circle") !== null) {

    // count-down timer
    let countdown_time = parseInt(document.querySelector('#countdown_time').value);
    const circle = document.querySelector('#circle_offset') // .setAttribute("stroke-dashoffset") 100==0 
    const circle_text = document.querySelector('#circle_text') // innerHTML
    let leftover = 100;

    let x = setInterval(function () {
        leftover = leftover - Math.round(100/countdown_time);
        
        // Check if the countdown has reached zero or negative
        if (leftover < 0) {
            clearInterval(x); // Stop the countdown 
            document.querySelector('.quiz-action-btn').style.display = 'block';
            document.querySelector('.countdown-circle').style.display = 'none';
            return; // Exit the function
        }

        circle.setAttribute("stroke-dashoffset",  leftover)
        circle_text.innerHTML = (100 - leftover) + '%';
        

    }, 1000);
}
