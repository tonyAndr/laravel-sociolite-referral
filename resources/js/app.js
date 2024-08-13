import axios from 'axios';
import './bootstrap';
import './countdown';

let Toast;
try {
    Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        iconColor: 'white',
        customClass: {
          popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: false,
      })
} catch (err) {
    //
}


document.addEventListener("DOMContentLoaded", () => {
    let socialButtons = document.querySelectorAll('.social-button');

    socialButtons.forEach((button) => {
        button.addEventListener('click', socialButtonClickHandler)
    })

    let ref_copy_btn = document.querySelector("#ref_copy_btn");
    let ref_link_textbox = document.querySelector("#ref_link_textbox");
    if (ref_copy_btn) {
        ref_copy_btn.addEventListener('click', referralButtonClickHandler);
    }
    if (ref_link_textbox) {
        ref_link_textbox.addEventListener('click', referralButtonClickHandler);
    }

    let input_robux_withdraw = document.querySelector("#robux");
    let robux_gamepass = document.querySelector("#gamepass_price");
    if (input_robux_withdraw) {

        input_robux_withdraw.addEventListener('input', function (e) {
            let robux = parseInt(input_robux_withdraw.value)
            let gamepass = robux + Math.ceil(robux*0.43)
            robux_gamepass.innerHTML = gamepass
        })
    }

    let btn_withdraw = document.querySelector("#btn_withdraw_user");
    let withdraw_spinner = document.querySelector("#progress_spinner");
    if (btn_withdraw) {
        btn_withdraw.addEventListener('click', function (e) {
            e.preventDefault()
            handleWithdrawPlacement();
        });
    }

    let handleWithdrawPlacement = async () => {
        let robux = document.querySelector("#robux").value

        if (!robux) {
            Toast.fire({
                icon: 'warning',
                title: 'Укажи количество робуксов',
            })
            return;
        }

        btn_withdraw.disabled = true
        withdraw_spinner.hidden = false
        axios.post('/withdrawal/create', {
            amount: document.querySelector("#robux").value,
        })
        .then(function (response) {
            // handle success
            console.log(response);

            if (!response.data.result) {
                let msg = 'Недостаточно средств на балансе!';
                if (response.data.msg === 'insufficient_balance') {
                    msg = 'Недостаточно средств на балансе!';
                }
                if (response.data.msg === 'minimum_sum') {
                    msg = 'Минимальная сумма для вывода - 100 робуксов';
                }

                Toast.fire({
                    icon: 'warning',
                    title: msg,
                })
                btn_withdraw.disabled = false
            } else {
                Toast.fire({
                    icon: 'success',
                    title: 'Заявка отправлена',
                })
            }
        })
        .catch(function (error) {
            // handle error
            console.log(error);
            Toast.fire({
                icon: 'warning',
                title: 'Ошибка при создании заявки!',
            })
        })
        .finally(function () {
            setTimeout(function() {
                window.location = "/withdrawal";
            }, 1000)
        })
    }
    let approve_withdrawal_btn = document.querySelectorAll("#approve_withdrawal_btn");
    let cancel_withdrawal_btn = document.querySelectorAll("#cancel_withdrawal_btn");
    if (cancel_withdrawal_btn.length) {
        cancel_withdrawal_btn.forEach(element => {
            
            element.addEventListener('click', function (e) {
                e.preventDefault()
                element.disabled = true
                let withdrawal_id = element.getAttribute('data-withdrawal-id');
                let reason = prompt('Причина отмены')
                if (!reason) {
                    alert('Укажи причину отмены')
                } else {

                    axios.post('/withdrawal/cancel', {
                        id: withdrawal_id,
                        reason: reason
                    })
                    .then(function (response) {
                        // handle success
                        console.log(response);
        
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
        
                    })
                    .finally(function () {
                        Toast.fire({
                            icon: 'info',
                            title: 'Выплата отменена',
                        })
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000)
                    })
                }
            });
        });
    }
    if (approve_withdrawal_btn.length) {
        approve_withdrawal_btn.forEach(element => {
            
            element.addEventListener('click', function (e) {
                e.preventDefault()
                element.disabled = true
                let withdrawal_id = element.getAttribute('data-withdrawal-id');
                let redeem_code = prompt('Код карты')
                if (!redeem_code) {
                    alert('Укажи код карты')
                } else {

                    axios.post('/withdrawal/approve', {
                        id: withdrawal_id,
                        redeem_code: redeem_code
                    })
                    .then(function (response) {
                        // handle success
                        console.log(response);
        
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
        
                    })
                    .finally(function () {
                        Toast.fire({
                            icon: 'success',
                            title: 'Выплата подтверждена',
                        })
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000)
                    })
                }
    
            });
        });
    }


    let yandex_reward_start_btn = document.querySelector("#yandex_reward_start_btn");
    if (yandex_reward_start_btn) {
        yandex_reward_start_btn.addEventListener('click', function (e) {
            e.preventDefault()

            Toast.fire({
                icon: 'info',
                title: 'Задание временно не доступно. Попробуй офферволы',
            })
            return;

            let rewardUser = (isRewarded) => {
                if (isRewarded) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Награда получена!',
                    })
                    axios.get('/partner/callback/yandex')
                        .then(function (response) {
                            // handle success
                            console.log(response);
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })
                        .finally(function () {
                            // always executed
                            setTimeout(function() {
                                window.location = "/dashboard";
                            }, 1000)
                        });
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Реклама закрыта раньше времени!',
                    })

                }

            }

            window.yaContextCb.push(() => {
                if (Ya.Context.AdvManager.getPlatform() === 'desktop') {
                  // вызов блока Rewarded для десктопной версии
                  Ya.Context.AdvManager.render({
                    blockId: 'R-A-6005102-2',
                    type: 'rewarded',
                    platform: 'desktop',
                    onRewarded: (isRewarded) => rewardUser(isRewarded)
                  });
                } else {
                  // вызов блока Rewarded для мобильной версии
                  Ya.Context.AdvManager.render({
                    blockId: 'R-A-6005102-1',
                    type: 'rewarded',
                    platform: 'touch',
                    onRewarded: (isRewarded) => rewardUser(isRewarded)
                  });
                }
            });
        });
    }

    // Notify giveaway ended'
    const giveaway_winner = document.querySelector('#last_giveaway_won') 
    if (giveaway_winner) {
        let title = '';
        let text = '';
        let icon = '';
        if (giveaway_winner.value === '0') {
            title = 'Началась новая раздача!'
            text = 'Прошлую раздачу выиграл кто-то другой... Участвуй снова, на этот раз точно повезет!'
            icon = 'warning'
        } else {
            title = 'ТЫ ВЫИГРАЛ РАЗДАЧУ!'
            text = 'Робуксы уже спешат к тебе! Проверь сообщение от нашего бота в телеграме, мы уже выслали тебе твою награду!'
            icon = 'success'
        }
        let current_cookies = document.cookie;
        if (current_cookies.indexOf('cookie_giveaway_alert') === -1) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showConfirmButton: false
            })
            let cd_time = document.querySelector('#countdown_time').value;
            document.cookie = "cookie_giveaway_alert=1; max-age="+cd_time+"; path=/giveaway";
        }
    }

    const task_forms_buttons = document.querySelectorAll('button[name="btn-start"], button[name="btn-finish"], button[name="btn-cancel"]');
    const task_forms = document.querySelectorAll('#start_task_form,#finish_task_form,#cancel_task_form');
    // Iterate through the buttons or work with them as needed
    task_forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            // e.preventDefault()
            task_forms_buttons.forEach(button => {
                    // e.preventDefault()
                    button.disabled = true;
        
                    // setTimeout(() => {
                    //     button.disabled = false;
                    //   }, 3000);
            });
        });
    });

});

function referralButtonClickHandler(e) {
    let el = document.querySelector("#ref_link_textbox");
    if (el === undefined) return;
    if (window.clipboardData && window.clipboardData.setData) {
        clipboardData.setData("Text", el.textContent);
    } else {
        navigator.clipboard.writeText(el.textContent)
    }
    Toast.fire({
        icon: 'info',
        title: 'Ссылка скопирована!',
    })
}
function socialButtonClickHandler(e) {
    const popupWidth = 780;
    const popupHeight = 550;

    let el = identifyTargetElement(e, provideMissingTargetElementHandler(e));
    if (el === undefined) return;

    if (el.id === 'clip') {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (window.clipboardData && window.clipboardData.setData) {
            clipboardData.setData("Text", el.href);
        } else {
            let textArea = document.createElement("textarea");
            textArea.value = el.href;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("copy");  // Security exception may be thrown by some browsers.
            textArea.remove();
        }
        Toast.fire({
            icon: 'info',
            title: 'Ссылка скопирована!',
        })
        return;
    }

    const windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    const windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

    const vPosition = Math.floor((windowWidth - popupWidth) / 2),
        hPosition = Math.floor((windowHeight - popupHeight) / 2);

    const popup = window.open(el.href, 'social',
        'width=' + popupWidth + ',height=' + popupHeight +
        ',left=' + vPosition + ',top=' + hPosition +
        ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

    if (popup) {
        e.preventDefault();
        e.stopImmediatePropagation();
        popup.focus();
    }
}

function identifyTargetElement(e, cb) {
    let buttonClassName = 'social-button';

    if (
        e.target.parentElement &&
        e.target.parentElement.className.indexOf(buttonClassName) !== -1
    ) {
        return e.target.parentElement;
    }

    if (
        e.target.className.indexOf(buttonClassName) !== -1
    ) {
        return e.target;
    }

    typeof cb === 'function' && cb(buttonClassName)
}

// this function can be modified to handle a missing target element
// don't remove it because it is used in the socialButtonClickHandler
function provideMissingTargetElementHandler(e) {
    // returns a function with an enclosing e variable (contains a triggered event)
    // accepts a name argument (contains a classname used to identify a target element)
    return (name) => {
    }
}

document.addEventListener("DOMContentLoaded", () => {
    
});