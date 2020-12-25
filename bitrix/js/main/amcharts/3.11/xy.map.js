{"version":3,"file":"xy.min.js","sources":["xy.js"],"names":["AmCharts","AmXYChart","Class","inherits","AmRectangularChart","construct","a","this","type","base","call","cname","theme","createEvents","maxZoomFactor","applyTheme","initChart","dataChanged","updateData","dispatchDataUpdated","updateScrollbar","drawChart","autoMargins","marginsUpdated","measureMargins","marginLeftReal","c","marginTopReal","b","plotAreaWidth","d","plotAreaHeight","graphsSet","clipRect","bulletSet","trendLinesSet","prepareForExport","clipPath","container","remove","createValueAxes","xAxes","yAxes","valueAxes","e","length","f","position","rotate","setOrientation","orientation","push","ValueAxis","processValueAxis","graphs","processGraph","ifArray","chartData","chartScrollbar","updateScrollbars","zoomChart","cleanChart","hideXScrollbar","scrollbarH","removeListener","handleHSBZoom","destroy","hideYScrollbar","scrollbarV","handleVSBZoom","dispDUpd","chartCreated","zoomScrollbars","callMethod","chartCursor","toggleZoomOutButton","zoomObjects","zoomTrendLines","dispatchAxisZoom","heightMultiplier","widthMultiplier","showZB","isNaN","min","max","coordinateToValue","verticalPosition","horizontalPosition","dispatchZoomEvent","updateObjectSize","zoom","parseData","dataProvider","Infinity","k","g","data","valueField","m","h","Number","maxValue","minValue","valueBalloonsEnabled","zoomOut","chart","minMaxField","minTemp","NaN","maxTemp","listenTo","handleAxisSelfZoom","isString","xAxis","getValueAxisById","yAxis","valueAxis","axes","x","y","id","q","n","serialDataItem","index","p","l","value","xField","yField","errorField","error","values","processFields","graph","formatString","numberFormatter","nf","formatValue","indexOf","formatDataContextValue","dataContext","addChartScrollbar","scrollbarHeight","split","SimpleChartScrollbar","skipEvent","copyProperties","updateTrendLines","trendLines","processObject","TrendLine","valueAxisX","updateMargins","getScrollbarPosition","adjustMargins","updateChartScrollbar","draw","relativeZoom","fitMultiplier","multiplier","setAnimationPlayed","handleCursorZoom","selectionWidth","selectionHeight","selectionX","selectionY","removeChartScrollbar","handleReleaseOutside"],"mappings":"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"}