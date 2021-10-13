const out = document.querySelector('#out')
const btns = document.querySelectorAll('.btn-send')

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
const id = params.id

btns.forEach(btn => {
  btn.addEventListener('click', () => {
    const rows = document.querySelectorAll('#add-rows tr')
    postData(rows, 'modules', id)
  })
})

getData(type='modules', id)


// close btns
const btnBack = document.querySelector('#btn-back')
const btnDone = document.querySelector('#btnDone')
const btnNextModule = document.querySelector('#btnNext')

btnBack.addEventListener('click', () => getParent('plans', id))

btnDone.addEventListener('click', () => {
  getParent('plans', id)
})

checkId('plans', parseInt(id) + 1).then(res => {
  console.log(res);
  if (res) {
    btnNextModule.classList.remove('disabled')
    btnNextModule.disabled = false;
    btnNextModule.addEventListener('click', () => {
      document.location = `./modules.html?id=${parseInt(id)+1}` 
    })
  }
})