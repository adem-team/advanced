<?php
use yii\helpers\Html;
?>
<div class="container">
  <h4>VALIDATION STATUS PROSES DATA</h4>  
  <div class="col-sm-8">
		<p>Status prosess flow prosess data:</p> 
		<table class="c table table-bordered">
			<thead>
			  <tr>
				<th>NO</th>
				<th>STATUS ITEM </th>
				<th>STATUS SIGN</th>
				<th>STATUS CRUD</th>
				<th>STATUS BUTTON</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td>0</td>
				<td>CREATE -> New</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			  </tr>
			  <tr>
				<td>1</td>
				<td>Approve -> Approved</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			  </tr>
			  <tr>
				<td>3</td>
				<td>Delete -> Hide</td>
				<td></td>
				<td>Delete -> Hide</td>
				<td>Delete -> Hide</td>
			  </tr>
			  <tr>
				<td>4</td>
				<td>Reject -> Reject</td>
				<td>Reject -> Reject</td>
				<td>-</td>
				<td>-</td>
			  </tr>
			  <tr>
				<td>5</td>
				<td>-</td>
				<td>Panding -> Panding</td>
				<td>-</td>
				<td>-</td>
			  </tr>
			  <tr>
				<td>101</td>
				<td>-</td>
				<td>Created -> Process</td>
				<td>-</td>
				<td>|View |Delete |Edit</td>
			  </tr>
			   <tr>
				<td>102</td>
				<td>-</td>
				<td>Check -> Checked</td>
				<td>-</td>
				<td>|View |Review</td>
			  </tr>
			   <tr>
				<td>103</td>
				<td>-</td>
				<td>Approve -> Approved</td>
				<td>-</td>
				<td>|View |Review</td>
			  </tr>
			</tbody>
		</table>
	</div>
	
	<div class="col-sm-12">
		</br>
			<p>STATUS FLOW DATA RO dan SO<p>
		<dl>
		  <dt style="width:150px; float:left">1. NEW   		= 0</dt><dd>: Create First</dd>
		  <dt style="width:150px; float:left">2. PROCESS	= 101</dt><dd>: Sign Auth1 | Data Sudah di buat dan di tanda tangani</dd>
		  <dt style="width:150px; float:left">3. CHECKED	= 102</dt><dd>: Sign Auth2 | Data Sudah Di Check dan di tanda tangani</dd>
		  <dt style="width:150px; float:left">4. APPROVED	= 103</dt><dd>: Sign Auth3 | Data Sudah Di disetujui dan di tanda tangani</dd>
		  <dt style="width:150px; float:left">5. DELETE		= 3 </dt><dd>: Data Hidden | Data Di hapus oleh pembuat petama, jika belum di Approved</dd>
		  <dt style="width:150px; float:left">6. REJECT		= 4	</dt><dd>: Data tidak di setujui oleh manager atau Atasan  lain</dd>
		  <dt style="width:150px; float:left">7. UNKNOWN	<>	</dt><dd>: Data Tidak valid atau tidak sah</dd>
		</dl>
	</div>
	<div class="col-sm-12">
		<dl>
			<dt style="width:100px; float:left">Start</dt>
			<dd>data:image/svg+xml;base64,</dd>
			<dt style="width:100px; float:left">Sub1</dt>
			<dd>PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+</dd>
			<dt style="width:100px; float:left">Sub2</dt>
			<dd>PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIi</dd>
			<dd>	AiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkI</dd>
			<dd>	j48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0i</dd>
			<dd>	MS4xIiB3aWR0aD0iMjI4IiBoZWlnaHQ9IjU0Ij48cGF0aCBzdHJva2UtbGluZWpvaW4</dd>
			<dd>	9InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3</dd>
			<dd>	Ryb2tlPSJyZ2IoNTEsIDUxLCA1MSkiIGZpbGw9Im5vbmUiIGQ9Ik0g</dd>
			
			<dt style="width:100px; float:left">Isi</dt>
			<dd>xxxxxx isi xxxx=</dd>
			<dt style="width:100px; float:left">End</dt>
			<dd>spasi+PC9zdmc+</dd>
			tanda = terakhir adalah sepasi
		<dl>
	</div>
</div>


