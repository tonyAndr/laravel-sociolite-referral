document.addEventListener("DOMContentLoaded", () => {
    let yandex_reward_start_btn = document.querySelector("#yandex_reward_start_btn");
    if (yandex_reward_start_btn) {
        yandex_reward_start_btn.addEventListener('click', function (e) {
            e.preventDefault()

            let rewardUser = (isRewarded, tst) => {
                if (isRewarded) {
                    tst.fire({
                        icon: 'success',
                        title: 'Награда получена!',
                    })
                } else {
                    tst.fire({
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
                    onRewarded: (isRewarded) => (rewardUser(isRewarded), Toast)
                  });
                } else {
                  // вызов блока Rewarded для мобильной версии
                  Ya.Context.AdvManager.render({
                    blockId: 'R-A-6005102-1',
                    type: 'rewarded',
                    platform: 'touch',
                    onRewarded: (isRewarded) => (rewardUser(isRewarded), Toast)
                  });
                }
            });
        });
    }
});