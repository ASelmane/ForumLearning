function displayModifBtn(){
    if (onClickBtnLike() || onClickBtnDislike()){
        console.log('ok');
        $('#user-modif-btn').addClass('d-none');
    }
}

function onClickBtnLike(event) {
    event.preventDefault();

    const url = this.href;
    const spanCountLike = this.querySelector('span.js-likes')
    const spanCountDislike = this.parentNode.parentNode.querySelector('span.js-dislikes');
    const iconLike = this.querySelector('span.like');
    const iconDislike = this.parentNode.parentNode.querySelector('span.dislike');

    axios.get(url).then(function (response) {
        spanCountLike.textContent = response.data.likes;
        if (iconLike.innerHTML === "thumb_up_off_alt") {
            iconLike.innerHTML = "thumb_up";
            $('#user-modif-btn').addClass('d-none');
        } else {
            iconLike.innerHTML = "thumb_up_off_alt";
            $('#user-modif-btn').removeClass('d-none');
        }
        if (iconDislike.innerHTML === "thumb_down") {
            spanCountDislike.textContent = response.data.dislikes;
            iconDislike.innerHTML = 'thumb_down_off_alt';
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
    const spanCountLike = this.parentNode.parentNode.querySelector('span.js-likes');
    const iconDislike = this.querySelector('span.dislike');
    const iconLike = this.parentNode.parentNode.querySelector('span.like');



    axios.get(url).then(function (response) {
        spanCountDislike.textContent = response.data.dislikes;
        if (iconDislike.innerHTML === "thumb_down_off_alt") {
            iconDislike.innerHTML = "thumb_down";
            $('#user-modif-btn').addClass('d-none');
        } else {
            iconDislike.innerHTML = "thumb_down_off_alt";
            $('#user-modif-btn').removeClass('d-none');
        }
        if (iconLike.innerHTML === "thumb_up") {
            spanCountLike.textContent = response.data.likes;
            iconLike.innerHTML = 'thumb_up_off_alt';
            $('#user-modif-btn').addClass('d-none');
        }
    })
}

document.querySelectorAll('a.js-dislike').forEach(function (link) {
    link.addEventListener('click', onClickBtnDislike)
})