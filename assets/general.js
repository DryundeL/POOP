const btnSend = document.querySelector('#btnSend')
const inputIndex = document.querySelector('#index')
const inputName = document.querySelector('#name')
const inputAll = document.querySelector('#all')
const inputDisciplines = document.querySelector('#disciplines')
const inputPractices = document.querySelector('#practices')
const inputWork = document.querySelector('#self-work')

const out = document.querySelector('.out')

function getStudPlane(){
  fetch('./php/database.php')
    .then(res => res.json())
    .then(res=>{
     res.forEach(result=>{
       console.log(result)
       out.innerHTML += `<span>${result.index_plan} ${result.name} ${result.all_plan} ${result.disciplines} ${result.practices} ${result.individual_work}</span>`
     })
    })
}
getStudPlane()

btnSend.addEventListener('click', ()=>{
  fetch('./php/database.php', {
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

const btnAddStr = document.querySelector('.addStr')
const studPlane = document.querySelector('.stud_plan')

btnAddStr.addEventListener('click', ()=>{
  studPlane.innerHTML +=`<input type="text" id="index">
  <input type="text" id="name">
  <input type="text" id="all">
  <input type="text" id="disciplines">
  <input type="text" id="practices">
  <input type="text" id="self-work">`
})