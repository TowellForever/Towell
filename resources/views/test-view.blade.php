@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
  <h1 class="text-2xl font-bold text-center mb-4">Demo JavaScript Avanzado</h1>

  <div class="mb-4 flex justify-between">
    <input id="search" type="text" placeholder="Buscar orden..." class="border rounded px-3 py-1 w-1/2" />
    <button id="reset" class="bg-gray-500 text-white px-3 py-1 rounded">Reset</button>
  </div>

  <div class="overflow-auto max-h-[70vh] border">
    <table id="demoTable" class="min-w-full table-auto border-collapse">
      <thead class="bg-blue-600 text-white sticky top-0">
        <tr>
          <th data-field="id">ID</th>
          <th data-field="order">Orden</th>
          <th data-field="client">Cliente</th>
          <th data-field="status">Estatus</th>
          <th data-field="quantity">Cantidad</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>



<script>
(function(){
  'use strict';

  // Simulación de datos estáticos
  const rawData = Array.from({length: 100}, (_, i) => ({
    id: i + 1,
    order: 'ORD-' + String(i + 1).padStart(4, '0'),
    client: ['ACME','Globex','Initech','Umbrella'][i % 4],
    status: i % 2 === 0 ? 'Programada' : 'En Proceso',
    quantity: Math.floor(Math.random() * 1000)
  }));

  // Generador para paginación infinita
  function* paginator(data, pageSize=20) {
    for(let i=0; i<data.length; i+=pageSize) {
      yield data.slice(i, i+pageSize);
    }
  }

  // Debounce utility
  const debounce = (fn, delay=300) => {
    let timeout;
    return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(() => fn.apply(this, args), delay);
    };
  };

  class AdvancedTable {
    constructor(tableSelector, searchSelector) {
      this.table = document.querySelector(tableSelector);
      this.tbody = this.table.querySelector('tbody');
      this.searchInput = document.querySelector(searchSelector);
      this.data = rawData;
      this.currentData = [...this.data];
      this.pageGen = paginator(this.currentData);
      this.currentPage = this.pageGen.next();
      this.registerEvents();
      this.renderRows(this.currentPage.value);
    }

    registerEvents(){
      // Búsqueda con debounce
      this.searchInput.addEventListener('input', debounce(e => {
        this.filter(e.target.value.trim().toLowerCase());
      }, 200));

      // Orden por columnas
      this.table.querySelectorAll('th').forEach(th => {
        let asc = true;
        th.style.cursor = 'pointer';
        th.addEventListener('click', () => {
          this.sort(th.dataset.field, asc);
          asc = !asc;
        });
      });

      // Scroll para cargar siguiente página
      this.table.parentElement.addEventListener('scroll', () => {
        const {scrollTop, scrollHeight, clientHeight} = this.table.parentElement;
        if(scrollTop + clientHeight >= scrollHeight - 5 && !this.currentPage.done){
          const next = this.pageGen.next();
          if(!next.done) this.renderRows(next.value, true);
        }
      });

      // Reset
      document.getElementById('reset').addEventListener('click', () => {
        this.reset();
      });
    }

    filter(term) {
      this.currentData = this.data.filter(item =>
        Object.values(item).some(val =>
          String(val).toLowerCase().includes(term)
        )
      );
      this.resetTable();
    }

    sort(key, asc=true) {
      this.currentData.sort((a,b) => 
        String(a[key]).localeCompare(b[key], undefined, {numeric:true}) * (asc?1:-1)
      );
      this.resetTable();
    }

    reset() {
      this.searchInput.value = '';
      this.currentData = [...this.data];
      this.resetTable();
    }

    resetTable() {
      // Clear y reiniciar paginador
      this.tbody.innerHTML = '';
      this.pageGen = paginator(this.currentData);
      this.currentPage = this.pageGen.next();
      this.renderRows(this.currentPage.value);
    }

    renderRows(rows, append=false) {
      const fragment = document.createDocumentFragment();
      rows.forEach(row => {
        const tr = document.createElement('tr');
        for(const field of ['id','order','client','status','quantity']){
          const td = document.createElement('td');
          td.textContent = row[field];
          td.classList.add('border','p-2');
          tr.appendChild(td);
        }
        fragment.appendChild(tr);
      });
      this.tbody.append(append ? fragment : fragment);
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    new AdvancedTable('#demoTable','#search');
  });
})();
</script>


@endsection