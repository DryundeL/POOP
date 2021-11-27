const out = document.querySelector('#out')
const btns = document.querySelectorAll('.btn-send')

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
const id = params.id


btns.forEach(btn => {
  btn.addEventListener('click', () => {
    const moduleThemes = document.querySelectorAll('#module-theme')
    const contents = document.querySelectorAll('#content')
    const lessonTypes = document.querySelectorAll('#lesson-type')
    const hoursCount = document.querySelectorAll('#hours-count')
    
    let themePlans = [...moduleThemes, ...contents, ...lessonTypes, ...hoursCount]
    
    secondPostData(themePlans, 'themePlan', id)
  })
})

getData(type='themePlan', id)


// close btns
const btnBack = document.querySelector('#btn-back')
const btnDone = document.querySelector('#btnDone')
const btnNextModule = document.querySelector('#btnNext')
const btnSend = document.querySelector('#btnSend')

btnBack.addEventListener('click', () => getParent('modules', id))

btnDone.addEventListener('click', () => {
  getParent('modules', id)
})

checkId('modules', parseInt(id) + 1).then(res => {
  if (res) {
    btnNextModule.classList.remove('disabled')
    btnNextModule.disabled = false;
    btnNextModule.addEventListener('click', () => {
      document.location = `./themePlan.html?id=${parseInt(id)+1}` 
    })
  }
})