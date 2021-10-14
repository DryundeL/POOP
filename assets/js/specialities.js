const out = document.querySelector('#out')
const btnSend = document.querySelector('#btnSend')

btnSend.addEventListener('click', () => {
  const rows = document.querySelectorAll('#add-rows tr')
  postData(rows, 'specialities')
})

getData(type='specialities')