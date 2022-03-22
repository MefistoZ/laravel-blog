require('./bootstrap');

// post request
async function postData(url = '', data = {}) {
    const response = await fetch(url, {
        method: 'POST',
        body: data
    });
    return await response.json();
}

// handle submit form action
function commentFormAjaxInit() {
    const form = document.querySelector('form[name=comment]')
    if (form) {
        form.addEventListener('submit', e => {
            e.preventDefault();
            let formData = new FormData(form);
            postData(form.getAttribute('action'), formData).then(response => {
                form.querySelector('textarea').value = ''
                document.querySelector('#task-comments').insertAdjacentHTML('afterbegin', getCommentView(response))
            })
        })
    }
}

commentFormAjaxInit();

function getCommentView(data) {
    return `<div id="comment-wrap" class="bg-white rounded-lg p-3  flex flex-col  shadow-lg mb-4">
        <div class="flex flex-row justify-between mr-2">
            <h3 class="text-purple-600 font-semibold text-lg text-center md:text-left ">${data.data.user_name}</h3>
            <button type="button" onClick="deleteComment(${data.data.id}, this)" id="delete-comment"
                    class="close md:text-left" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <p style="width: 90%" class="text-gray-600 text-lg text-center md:text-left ">${data.data.text}</p>
    </div>`
}

// --------- comment delete ----------
window.deleteComment = function (id, el) {
    if (confirm('Вы действительно хотите удалить коммент?')) {
        axios.post('/posts/comment/' + id, {
            _method: 'DELETE'
        })
            .then(response => {
                el.closest('#comment-wrap').remove()
            })
            .catch(error => {
                console.log(error)
            })
    }
}


