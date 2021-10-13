function postData(rows, type, parent = undefined) {
  const records = []
  rows.forEach(row => {
    const record = {}
    const inputs = row.children
    
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
  }).then(() => getData(type, parent))
}

function getData(type, parent = undefined) {
  fetch(`./php/api/${type}.php${type !== 'plans' ? '?id=' + parent : ''}`)
    .then(res => res.json())
    .then(res=>{
      out.innerHTML = ''
      Object.values(res).forEach(row => {
        const tr = document.createElement('tr')

        if (type === 'specialities') {
          tr.addEventListener('click', () => document.location = `./plans.html?id=${row.id}`)
        } else if (type === 'plans') {
          tr.addEventListener('click', () => document.location = `./modules.html?id=${row.id}`)
        } else if (type === 'modules') {
          tr.addEventListener('click', () => document.location = `./skills.html?id=${row.id}`)
        }
        
        Object.entries(row).forEach(col => {
          const key = col[0]
          const value = col[1]
          if (key === 'id' || key === 'parent' || key === 'code') return

          const td = document.createElement('td')
          td.textContent = value
          tr.append(td)
        })
        out.append(tr)
     })
    })
}

const btnAdd  = document.querySelector('.addStr')
const addRows = document.querySelector('#add-rows')
const addRow  = document.querySelector('#add-row')

btnAdd.addEventListener('click', ()=>{
  addRows.insertAdjacentHTML(
    'beforeend',
    addRow.outerHTML
  )
})