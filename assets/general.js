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
      Object.values(res).forEach(result=>{
       console.log(result)
       out.innerHTML += `<span>${result.index_plan} ${result.name} ${result.all_plan} ${result.disciplines} ${result.practices} ${result.individual_work}</span><br>`
     })
    })
}
getStudPlane()

const btnSend = document.querySelector('#btnSend')

btnSend.addEventListener('click', ()=>{
  const records = []
  const studyRows = document.querySelectorAll('.study-plan div')
  studyRows.forEach(row => {
    const childrens = row.children
    const newStudyPlan = {
      'index':       childrens[0].value,
      'name':        childrens[1].value,
      'all':         childrens[2].value,
      'disciplines': childrens[3].value,
      'practices':   childrens[4].value,
      'self_work':   childrens[5].value,
    }
    records.push(newStudyPlan)
  })

  fetch('./php/database.php', {
    method:"POST",
    body: JSON.stringify({records})
  })

  inputIndex.value=""
  inputName.value=""
  inputAll.value=""
  inputDisciplines.value=""
  inputPractices.value=""
  inputWork.value=""
})



const btnAddStr = document.querySelector('.addStr')
const studPlane = document.querySelector('.study-add__rows')

btnAddStr.addEventListener('click', ()=>{
  studPlane.innerHTML +=`
  <div class="study-add__item-row">
    <input type="text" id="index">
    <input type="text" id="name">
    <input type="text" id="all">
    <input type="text" id="disciplines">
    <input type="text" id="practices">
    <input type="text" id="self-work">
  </div>
  `
})