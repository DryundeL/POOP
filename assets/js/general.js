function postData(rows, type, parent = undefined) {
  const records = []
  rows.forEach(row => {
    const record = {}
    const inputs = row.querySelectorAll('input')
    
    Array.from(inputs).forEach(input => {
      const title = input.dataset.title
      record[title] = input.value
    })

    records.push(record)
  })

  fetch(`./php/api/${type}.php`, {
    method:"POST",
    body: JSON.stringify({
      type,
      parent,
      items: records,
    })
  }).then(() => {
    if (type === 'skills') 
      getData(type, parent)
    else 
      getLastId(type).then(id =>
        document.location = `./${getNextType(type)}.html?id=${id}` 
      )
  })

  rows.forEach(row => {   
    const inputs = row.children 
    Array.from(inputs).forEach(input => {
      input.value = ""
    })
  })
}

function getData(type, parent = undefined) {
  fetch(`./php/api/${type}.php${type !== 'specialities' ? '?id=' + parent : ''}`)
  .then(res => res.json())
  .then(res => {
    out.innerHTML = ''
    Object.values(res).forEach(row => {
      const tr = document.createElement('tr')

      if (type !== 'skills')
        tr.addEventListener('click', () => document.location = `./${getNextType(type)}.html?id=${row.id}`)
      
      Object.entries(row).forEach(col => {
        const key = col[0]
        const value = col[1]
        if (key === 'id' || key === 'parent' || key === 'code' || key === 'name_speciality') return

        const td = document.createElement('td')
        td.textContent = value
        td.dataset.title = key
        tr.append(td)
      })
      tr.innerHTML += `
          <td class="study-add__edit-icon" data-id="${row.id}">
            <img src="./assets/icons/edit.svg" alt="">
          </td>
        `
      out.append(tr)
    })

    const modal = document.querySelector('.modal')
    if (modal) {
      const editBtn = document.querySelectorAll('.study-add__edit-icon')
      editData(editBtn)
    }
  })
}

async function getLastId(type) {
  const res = await fetch(`./php/api/${type}.php`)
  const json = await res?.json()
  const id = Math.max(...Object.keys(json))
  return id
}

function getNextType(type) {
  const types = ['specialities', 'plans', 'modules', 'skills']
  const indexCurrentType = types.indexOf(type)
  return types[indexCurrentType + 1]
}

function getPrevType(type) {
  const types = ['specialities', 'plans', 'modules', 'skills']
  const indexCurrentType = types.indexOf(type)
  return types[indexCurrentType - 1]
}

async function checkId(type, id) {
  const res = await fetch(`./php/api/${type}.php`)
  const json = await res?.json()
  console.log(json);
  return Object.keys(json).filter(item => item == id).length > 0
}

async function getParent(type, id) {
  const res = await fetch(`./php/api/${type}.php`)
  const json = await res?.json()
  console.log(json);
  document.location = `./${type}.html?id=${json[id].parent}`
}

const btnAdd  = document.querySelector('.addStr')
const addRows = document.querySelector('#add-rows')
const addRow  = document.querySelector('#add-row')

btnAdd.addEventListener('click', () => {
  addRows.insertAdjacentHTML(
    'beforeend',
    addRow.outerHTML
  )
})

function editData (btnsArr) {
  const modal = document.querySelector('.modal')
  btnsArr.forEach(btn => {
    btn.addEventListener('click', event => {
      event.stopPropagation()
      modal.innerHTML = innerModal()

      const modalHeaders = document.querySelector('.modal__headers')
      const modalValues = document.querySelector('.modal__values')
      const formHeaders = document.querySelectorAll('.study-add__header th')
      const formValues = event.target.closest('tr').children

      formHeaders.forEach(header => {
        if (header.textContent === 'Дата обновления') return

        modalHeaders.innerHTML += `<span>${header.innerHTML}</span>`
      })
      Array.from(formValues).forEach(value => {
        if (value.className === 'study-add__edit-icon' || value.dataset.title === 'updated_at') return
        
        modalValues.innerHTML += `<input data-title="${value.dataset.title}" value="${value.textContent}" />`
      })

      modal.addEventListener('click', (e) => {
        if (e.target == modal || e.target.classList.contains('modal__close')) {
          closeModal(modal)
        }
      });

      const btnUpdate = document.querySelector('#btn-update')
      btnUpdate.addEventListener('click', () => {
        const inputs = modal.querySelectorAll('input')

        let type = window.location.pathname.split('.')[0].slice(1)
        if (type === 'index') type = 'specialities'

        const id = btn.dataset.id

        const record = {
          type: type,
          id: id,
          record: {}
        }
        inputs.forEach(input => {
          const title = input.dataset.title
          const value = input.value
          record.record[title] = value
        })

        fetch(`./php/api/${type}.php`, {
          method:"PUT",
          body: JSON.stringify({
            record
          })
        }).then(res =>document.location.reload())
        // document.location.reload();
      })

      showModal(modal)
    })
  })
}

function showModal(mod) {
  const html = document.getElementsByTagName('html')[0]
  document.body.style.top = `-${window.scrollY}px`
  html.style.position = 'fixed'
  mod.style.display = 'flex'
}

function closeModal(mod) {
  const html = document.getElementsByTagName('html')[0]
  const scrollY = document.body.style.top
  html.style.position = ''
  document.body.style.top = ''
  window.scrollTo(0, parseInt(scrollY || '0') * -1)
  mod.style.display = 'none'
}

function innerModal() {
  return  `
    <div class="modal__container">
      <img class="modal__close" src="./assets/icons/close.svg" />
      <p>Редактирование</p>
      <div class="modal__edit">
        <div class="modal__headers"></div>
        <div class="modal__values"></div>
      </div>
      <button class="btn" id="btn-update">Сохранить</button>
    </div>
  `
}