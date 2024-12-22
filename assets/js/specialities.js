const out = document.querySelector('#out')
const btnSend = document.querySelector('#btnSend')

btnSend.addEventListener('click', () => {
  const rows = document.querySelectorAll('#add-rows tr')
  postData(rows, 'specialities')
  rows.forEach(row => {
    const inputs = row.children
    Array.from(inputs).forEach(input => {
      input.value = ""
    })
  })
})

getData(type='specialities')