const btnSend = document.querySelector('#btnSend')
const inputIndex = document.querySelector('#index')
const inputName = document.querySelector('#name')
const inputAll = document.querySelector('#all')
const inputDisciplines = document.querySelector('#disciplines')
const inputPractices = document.querySelector('#practices')
const inputWork = document.querySelector('#self-work')

btnSend.addEventListener('click', ()=>{
  fetch('./php/poop.php', {
    method:"POST",
    body: JSON.stringify({
      index: inputIndex.value,
      name: inputName.value,
      all: inputAll.value,
      disciplines: inputDisciplines.value,
      practices: inputPractices.value,
      self_work: inputWork.value
    })
  })
  inputIndex.value=""
  inputName.value=""
  inputAll.value=""
  inputDisciplines.value=""
  inputPractices.value=""
  inputWork.value=""
})