$(document).ready( function() {
	
	// Inicializamos tablas
	$('#tabla-matematica-planificaciones').DataTable( {
		"lengthChange": false,
		"pageLength": 10,
		"order": [ 0, 'desc' ],
		"language": {
			"paginate": {
				"first": "Primera página",
				"last": "Última página",
				"previous": "Atrás",
				"next": "Siguiente"
			},
			"emptyTable": "Aún no tienes ninguna planificación de esta asignatura",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No hay nada que mostrar"
		}
	} );
		
	$('#tabla-lenguaje-planificaciones').DataTable( {
		"lengthChange": false,
		"pageLength": 10,
		"order": [ 0, 'desc' ],
		"language": {
			"paginate": {
				"first": "Primera página",
				"last": "Última página",
				"previous": "Atrás",
				"next": "Siguiente"
			},
			"emptyTable": "Aún no tienes ninguna planificación de esta asignatura",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No hay nada que mostrar"
		}
	} );
	
	$('#tabla-tecnologia-planificaciones').DataTable( {
		"lengthChange": false,
		"pageLength": 10,
		"order": [ 0, 'desc' ],
		"language": {
			"paginate": {
				"first": "Primera página",
				"last": "Última página",
				"previous": "Atrás",
				"next": "Siguiente"
			},
			"emptyTable": "Aún no tienes ninguna planificación de esta asignatura",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No hay nada que mostrar"
		}
	} );
	
	$('#tabla-musica-planificaciones').DataTable( {
		"lengthChange": false,
		"pageLength": 10,
		"order": [ 0, 'desc' ],
		"language": {
			"paginate": {
				"first": "Primera página",
				"last": "Última página",
				"previous": "Atrás",
				"next": "Siguiente"
			},
			"emptyTable": "Aún no tienes ninguna planificación de esta asignatura",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No hay nada que mostrar"
		}
	} );
	
	$('#tabla-artesvisuales-planificaciones').DataTable( {
		"lengthChange": false,
		"pageLength": 10,
		"order": [ 0, 'desc' ],
		"language": {
			"paginate": {
				"first": "Primera página",
				"last": "Última página",
				"previous": "Atrás",
				"next": "Siguiente"
			},
			"emptyTable": "Aún no tienes ninguna planificación de esta asignatura",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No hay nada que mostrar"
		}
	} );
} );