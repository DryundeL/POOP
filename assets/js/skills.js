const out = document.querySelector('#out')
const btns = document.querySelectorAll('.btn-send')

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
const id = params.id

btns.forEach(btn => {
  btn.addEventListener('click', () => {
    const rows = document.querySelectorAll('#add-rows div')
    postData(rows, 'skills', id)
  })
})

getData(type='skills', id)