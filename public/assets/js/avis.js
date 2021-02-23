function onClickBtnLike(event) {
    event.preventDefault();

    const url = this.href;
    const spanCountLike = this.querySelector('span.js-likes')
    const spanCountDislike = this.parentNode.querySelector('span.js-dislikes');
    const iconLike = this.querySelector('span.like');
    const iconDislike = this.parentNode.querySelector('span.dislike');
    const modifBtn = this.parentNode.parentNode.querySelector('a.user-modif-btn');

    const admin = this.parentNode.parentNode.parentNode.querySelector('input.jsAdmin').value;
    let date = new Date();
    const editLimit = this.parentNode.parentNode.parentNode.querySelector('input.jsEditLimit').value;
    const datePost = new Date(editLimit);
    const dateLimit = datePost.setMinutes( datePost.getMinutes() + 30 );

    axios.get(url).then(function (response) {
        spanCountLike.textContent = response.data.likes;
        if (iconLike.innerHTML === "thumb_up_off_alt") {
            iconLike.innerHTML = "thumb_up";
            if(date > dateLimit && admin == 0) $(modifBtn).addClass('d-none');
        } else {
            iconLike.innerHTML = "thumb_up_off_alt";
            if(date > dateLimit && admin == 0) $(modifBtn).removeClass('d-none');
        }
        if (iconDislike.innerHTML === "thumb_down") {
            spanCountDislike.textContent = response.data.dislikes;
            iconDislike.innerHTML = 'thumb_down_off_alt';
            if(date > dateLimit && admin == 0) $(modifBtn).addClass('d-none');
        }
    })
}

document.querySelectorAll('a.js-like').forEach(function (link) {
    link.addEventListener('click', onClickBtnLike)
})

function onClickBtnDislike(event) {
    event.preventDefault();

    const url = this.href;
    const spanCountDislike = this.querySelector('span.js-dislikes');
    const spanCountLike = this.parentNode.querySelector('span.js-likes');
    const iconDislike = this.querySelector('span.dislike');
    const iconLike = this.parentNode.querySelector('span.like');
    const modifBtn = this.parentNode.parentNode.querySelector('a.user-modif-btn');

    const admin = this.parentNode.parentNode.parentNode.querySelector('input.jsAdmin').value;
    let date = new Date();
    const editLimit = this.parentNode.parentNode.parentNode.querySelector('input.jsEditLimit').value;
    const datePost = new Date(editLimit);
    const dateLimit = datePost.setMinutes( datePost.getMinutes() + 30 );


    axios.get(url).then(function (response) {
        spanCountDislike.textContent = response.data.dislikes;
        if (iconDislike.innerHTML === "thumb_down_off_alt") {
            iconDislike.innerHTML = "thumb_down";
            if(date > dateLimit && admin == 0) $(modifBtn).addClass('d-none');
        } else {
            iconDislike.innerHTML = "thumb_down_off_alt";
            if(date > dateLimit && admin == 0) $(modifBtn).removeClass('d-none');
        }
        if (iconLike.innerHTML === "thumb_up") {
            spanCountLike.textContent = response.data.likes;
            iconLike.innerHTML = 'thumb_up_off_alt';
            if(date > dateLimit && admin == 0) $(modifBtn).addClass('d-none');
        }
    })
}

document.querySelectorAll('a.js-dislike').forEach(function (link) {
    link.addEventListener('click', onClickBtnDislike)
})