
/**
 * Apply search filter on a table
 * 
 * source https://www.w3schools.com/howto/howto_js_filter_table.asp
 * 
 * Changes:
 * - search in all columns
 * - search with multiple keywords using AND condition per line
 * 
 * @param {string} sIdInput  id of input field to fetch searchterm
 * @param {string} sIdTable  if of table to filter
 */
function doFilterTable(sIdInput, sIdTable) {
	var input, filter, table, tr, td, i, j, txtValue, bFound, q;

	var iVisible = 0;
	input = document.getElementById(sIdInput);
	filter = input.value.toUpperCase().split(" ");
	table = document.getElementById(sIdTable);
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];
		if (td) {
			// this searches in 1st column only:
			// txtValue = td.textContent || td.innerText;
			txtValue = tr[i].textContent || tr[i].innerText;

			// search for multiple terms - AND condition
			bFound = true;

			for (j = 0; j < filter.length; j++) {
				if (txtValue.toUpperCase().indexOf(filter[j]) === -1) {
					bFound = false;
				}
			}
			if(bFound) {
				iVisible++;
			}
			tr[i].style.display = bFound ? "" : "none";
		}
	}
	button=document.getElementsByClassName('resetfilter')[0];
	button.style.display = input.value ? 'inline' : '';
}

/**
 * Generate a search field on top of a given table
 * 
 * @param {string} sIdTable  if of table to filter
 * @returns boolean
 */
function addFilterTable(sIdTable) {
	var table, input, inputId;
	table = document.getElementById(sIdTable);
	if (!table) {
		return false;
	}
	inputId = 'search4' + sIdTable;

	input = document.createElement("input");
	input.type = "text";
	input.className = "searchfield";
	input.id = inputId;
	input.placeholder = "🔎 ...";
	
	table.parentNode.insertBefore(input, table);

	input.addEventListener('keyup', function () {
		doFilterTable(inputId, sIdTable);
	});

	button = document.createElement("button");
	button.innerText = "X";
	button.className = "resetfilter";

	table.parentNode.insertBefore(button, table);

	button.addEventListener('click', function () {
		filter("");
	});

	return true;
}

/*
 * Filter table by link click
 * 
 * @param {object|string} oLink  link object in html table ... 
 *                               or a string with filter value
 */
function filter(oLink) {
	var oTable, oSearchfield;
	// oTable=oLink.parentNode.parentNode.parentNode.parentNode;
	oTable=document.getElementsByTagName('table')[0];
	oSearchfield=document.getElementsByClassName('searchfield')[0];
	if(oLink.innerHTML){
		oSearchfield.value = oSearchfield.value 
			? oSearchfield.value + ' ' + oLink.innerHTML 
			: oLink.innerHTML;		
	} else {
		oSearchfield.value = oLink;
	}
	doFilterTable(oSearchfield.id, oTable.id);
}


// -----------------------------------------------------------------------------
// MAIN
// -----------------------------------------------------------------------------

addFilterTable('tblIcons');

// -----------------------------------------------------------------------------
