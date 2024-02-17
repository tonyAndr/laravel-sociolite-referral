import axios from 'axios';
import './bootstrap';

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
    let btn_withdraw = document.querySelector("#btn_withdraw");
    if (btn_withdraw) {
        btn_withdraw.addEventListener('click', function (e) {
            e.preventDefault()
            btn_withdraw.disabled = true
            axios.post('/withdrawal/create', {
                amount: document.querySelector("#robux").value
            })
            .then(function (response) {
                // handle success
                console.log(response);

                if (!response.data.result) {
                    let msg = 'Недостаточно средств на балансе!';
                    if (response.data.msg === 'insufficient_balance') {
                        msg = 'Недостаточно средств на балансе!';
                    }
                    if (response.data.msg === 'minimum_20') {
                        msg = 'Минимальная сумма для вывода - 20 робуксов';
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
                    setTimeout(function() {
                        window.location = "/withdrawal";
                    }, 1000)
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
                btn_withdraw.disabled = false
            })

        });
    }
    let approve_withdrawal_btn = document.querySelector("#approve_withdrawal_btn");
    if (approve_withdrawal_btn) {
        approve_withdrawal_btn.addEventListener('click', function (e) {
            e.preventDefault()
            approve_withdrawal_btn.disabled = true
            let withdrawal_id = approve_withdrawal_btn.getAttribute('data-withdrawal-id');
            axios.post('/withdrawal/approve', {
                id: withdrawal_id
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

        });
    }


    let yandex_reward_start_btn = document.querySelector("#yandex_reward_start_btn");
    if (yandex_reward_start_btn) {
        yandex_reward_start_btn.addEventListener('click', function (e) {
            e.preventDefault()

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