const generaTabla = (datos, titulo = '') => {

  let tabla = `
    <table class="datatable tableDatosSujeto text-uppercase" style="overflow-x: none; display: table; color: #000">
      <tbody class="table-datos-sujeto">
        <tr>
          <td colspan="2" style="background-color: #848F33; color: #FFF;" class="tx-center">${titulo}</td>          
        </tr>`

  if( !datos.length )
    tabla += `<tr><td colspan="2">Sin datos para mostrar</td></tr>`

  datos.forEach( dato => {
    tabla += `<tr><td>${dato[0]}</td><td>${dato[1]}</td></tr>`
  })
  
  tabla += '</tbody></table>'

  return tabla

}

const formateaFecha = ( fecha, options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'} ) => {

  const newDate = new Date( fecha )

  return newDate.toLocaleDateString('es-ES', options);

}

const creaAcordeon = ( contenido, titulo) => {

  const id = generaId()

  const acordeon =`
    <div id="accordion${id}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
      <div class="card">
        <div class="card-header" role="tab" id="headingOne">
          <a data-toggle="collapse" data-parent="#accordion${id}" href="#collapseOne${id}" aria-expanded="true" aria-controls="collapseOne${id}" class="tx-gray-800 transition collapsed">
            ${titulo}
          </a>
        </div><!-- card-header -->

        <div id="collapseOne${id}" class="collapse" role="tabpanel" aria-labelledby="headingOne${id}">
          <div class="card-body" >
            ${contenido}
          </div>
        </div>
      </div>
    </div>
  `

  return acordeon
}

const consumirServicio = async ( url, method, body = {}, headers = {} ) => {

  const init = { method }

  if( body.length ) 
    init = { ...init, body }

  if( headers.length )
    init = { ...init , headers }

  const solicitud = await fetch( url, init )
  
  if( solicitud.status == 200 ) 
    return await solicitud.json()
  
}

const generaId = () => {

  const random = Math.random().toString(36).substring(2)
    const fecha = Date.now().toString(36)
    return random + fecha

}

const formatearCantidad = cantidad => {
  return Number(cantidad).toLocaleString('en-US',{style:'currency',currency:'USD'})
}