/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

/* global moment:false, Chart:false, Sparkline:false */

$(document).ready(function (){
	var baseUrl = $('#burl').val()

  	// Make the dashboard widgets sortable Using jquery UI
	$('.connectedSortable').sortable({
		placeholder: 'sort-highlight',
		connectWith: '.connectedSortable',
		handle: '.card-header, .nav-tabs',
		forcePlaceholderSize: true,
		zIndex: 999999
	})

  	$('.connectedSortable .card-header').css('cursor', 'move')

	// jQuery UI sortable for the todo list
	$('.todo-list').sortable({
		placeholder: 'sort-highlight',
		handle: '.handle',
		forcePlaceholderSize: true,
		zIndex: 999999
	})

	// bootstrap WYSIHTML5 - text editor
	$('.textarea').summernote()

	/* jQueryKnob */
	$('.knob').knob()

	// The Calender
	$('#calendar').datetimepicker({
		format: 'L',
		inline: true
	})



	// jvectormap data
	// var visitorsData = await getVisitorsData()
	var visitorsData = []

	$.ajax({
		url: baseUrl+'api/dashboard/get-data',
		type: "POST",              
		dataType: 'json',                
		success: (req) => {
			loadingMap(req.acessos)
			loadingChartAcessoSolicitacao(req.acessosPorMes, req.solicitacoesPorMes)
		}
	});

	function loadingMap(data){
		// World map by jvectormap
		$('#world-map').vectorMap({
			map: 'world_mill',
			backgroundColor: 'transparent',
			regionStyle: {
				initial: {
					fill: 'rgba(255, 255, 255, 0.7)',
					'fill-opacity': 1,
					stroke: 'rgba(0,0,0,.2)',
					'stroke-width': 1,
					'stroke-opacity': 1
				}
			},
			series: {
				regions: [{
					values: data,
					scale: ['#C8EEFF', '#0071A4'],
					normalizeFunction: 'polynomial'
				}]
			},
			onRegionTipShow: function(e, el, code){
				if(data[code] !== undefined){
					el.html(el.html()+': '+data[code]+' visitantes');
				}
			}
		})
	}

	function loadingChartAcessoSolicitacao(acessos, solicitacoes){
		/* Chart.js Charts */
		// Sales chart
		var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')
		let dataAcessos = setDataChart(acessos)
		let dataSolicitacoes = setDataChart(solicitacoes)

		let teste =  [65, 59, 80, 81, 56, 55, 65, 59, 80, 81, 56, 55]

		console.log(dataSolicitacoes);
		console.log(teste);

		var salesChartData = {
			labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
			datasets: [
			{
				label: 'Acessos',
				borderColor: 'rgba(60,141,188,0.8)',
				pointColor: '#3b8bba',
				pointStrokeColor: 'rgba(60,141,188,1)',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(60,141,188,1)',
				data: dataAcessos
			},
			{
				label: 'Solicitações',
				borderColor: '#28A745',
				pointColor: 'rgba(210, 214, 222, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: dataSolicitacoes
			}
			]
		}

		var salesChartOptions = {
			maintainAspectRatio: false,
			responsive: true,
			scales: {
				xAxes: [{
					gridLines: {
						display: true
					}
				}],
				yAxes: [{
					gridLines: {
						display: true
					}
				}]
			},
			legend: {
				display: true,
				labels: {
					color: 'rgb(255, 99, 132)'
				}
			}
		}

		// This will get the first returned node in the jQuery collection.
		// eslint-disable-next-line no-unused-vars
		var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
			type: 'line',
			data: salesChartData,
			options: salesChartOptions
		})
	}

	function setDataChart(data){
		let defaultData = [0,0,0,0,50,0,0,0,0,0,0,0]
		let max = 12
		let retorno = []

		if(data !== undefined){
			if(typeof(data) == 'array' || typeof(data) == 'object'){
				// transformando object em array
				for(i = 0; i <= max; i++){
					if(data[i] === undefined){
						retorno.push(0)
					}else{
						retorno.push(data[i])
					}
				}

				return retorno
			}else{
				return defaultData
			}
		}else{
			return defaultData
		}
	}
})
