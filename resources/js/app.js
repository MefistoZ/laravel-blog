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
                document.querySelector('#task-comments').insertAdjacentHTML('beforeend', getCommentView(response))
            })
        })
    }
}
commentFormAjaxInit();

function getCommentView(data) {
    return `<div class="bg-white rounded-lg p-3  flex flex-col justify-center items-center md:items-start shadow-lg mb-4">
                <div class="flex flex-row justify-center mr-2">
                    <h3 class="text-purple-600 font-semibold text-lg text-center md:text-left ">${data.user_name}</h3>
                </div>
                <p style="width: 90%" class="text-gray-600 text-lg text-center md:text-left ">${data.text}</p>
            </div>`
}


