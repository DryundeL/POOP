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
        tr.append(td)
      })
      out.append(tr)
    })
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