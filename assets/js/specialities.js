const out = document.querySelector('#out')
const btnSend = document.querySelector('#btnSend')

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
const id = params.id

btnSend.addEventListener('click', () => {
  const rows = document.querySelectorAll('#add-rows div')
  postData(rows, 'specialities')
})

getData(type='specialities')