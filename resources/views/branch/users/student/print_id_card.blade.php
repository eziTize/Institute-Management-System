<div id="print_sec">
	<link rel="stylesheet" href="{{ Asset('css/custom/student_id_card.css') }}" type="text/css">
	<style>
		.header-part{
			background: url("{{ Asset('images/custom/student_id_card/top-blue.png') }}");
	    	background-repeat: no-repeat;
		}

		.footer-section{
			background: url("{{ Asset('images/custom/student_id_card/footer-blue.png') }}");
	    	background-repeat: no-repeat;
		}

		.impg-pic img{
		    margin-bottom: 0px !important;
		}

		.name-d ul li{
			list-style-type: none !important;
		}
	</style>


	<div class="container">
	    <div class="section">
			<div class="wrapper-student-id-preview">
				<div class="header-part">
					<div class="logo"><a><img src="{{ Asset('images/custom/student_id_card/logo.png') }}"></a></div>
					<h2>Exterior interior limited</h2>
					<div class="ns-pal"><img src="{{ Asset('images/custom/student_id_card/sd.png') }}"></div>
					<span>Ministry of Skill Development & Entrepreneship</span>
				</div>
				<div class="impg-pic"><img src="{{ Asset('upload/student/'.$data->photograph) }}"></div>
				<div class="name-d">
					<ul>
						<li>Name :</li>
						<li>{{ strtoupper($data->name) }}</li>
						<li>ID No :</li>
						<li>{{ $data->id }}</li>
						<li>Blood Group :</li>
						<li>{{ $data->blood_group }}</li>
						<li>Batch No :</li>
						<li>{{ $batch->name }}</li>
						<li>Course :</li>
						<li>{{ $course->name }}</li>
						<li>Conatct No:</li>
						<li>{{ $data->phone }}</li>
						<li>Alternate No:</li>
						<li>{{ $data->other_contact }}</li>
					</ul>
				</div>
				<div class="hj-lo">
					<div class="logo-section">
						<ul>
							<li><img src="{{ Asset('images/custom/student_id_card/com-1.jpg') }}"></li>
							<li><img src="{{ Asset('images/custom/student_id_card/com-2.jpg') }}"></li>
							<li><img src="{{ Asset('images/custom/student_id_card/com-3.jpg') }}"></li>
							<li><img src="{{ Asset('images/custom/student_id_card/com-4.jpg') }}"></li>
						</ul>
					</div>
					<div class="shain">
						<img src="{{ Asset('images/custom/student_id_card/sain.jpg') }}">
						<h3>Issuing Authority</h3>
					</div>
				</div>
				<div class="footer-section">
					<div class="footer-contain">
						<h2>Corporate & Asia Pacific Head Office</h2>
						<p>152,S.P Mukherjee Road, 5th & 6th Floor, ‘Abhishek Point Building’</p>
						<p>Kolkata - 700026 E:enquiry@exteriorinteriors.com</p>
						<p>P- +91 9836158666, +91 9903009562 | W : www.exteriorinteriors.com</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
  	function printDiv(divName) {
    	var printContents = document.getElementById(divName).innerHTML;
    	var originalContents = document.body.innerHTML;
    	document.body.innerHTML = printContents;
    	window.print();
    	document.body.innerHTML = originalContents;
  	}

  	window.addEventListener("load", function() {
    	printDiv('print_sec');
  	}, false);

  	window.onafterprint = function() {
    	close();
  	}
</script>