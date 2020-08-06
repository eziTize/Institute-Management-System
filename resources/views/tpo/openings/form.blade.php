
<div class="col s12 m12 l12">

	<div class="card-panel">

		<div class="row">

			<div class="input-field col s12">

				<i class="fa fa-info prefix"></i>

				{!! Form::text('company_name',null,['id' => 'company_name','required' => 'required']) !!}

				<label for="company_name">Company Name *</label>

			</div>

		</div>

		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-black-tie prefix"></i>

				{!! Form::text('o_type',null,['id' => 'o_type','required' => 'required']) !!}

				<label for="o_type">Opening Type *</label>

			</div>



			<div class="input-field col s12 l6">

				<i class="fa fa-calendar prefix"></i>

				{!! Form::date('date',null,['id' => 'date','required' => 'required', 'class' => 'datepicker' ]) !!}

        		<label for="date"> Interview Date *</label>

			</div>

		</div>



		<div class="row">

		<div class="input-field col s12 l12">
		
		<i class="fa fa-building prefix"></i>
		
		{!! Form::textarea('company_details',null,['id' => 'company_details','class' => 'materialize-textarea']) !!}
		<label for="company_details">Company Details *</label>
		
		</div>

		</div>


		<div class="row">

			<div class="input-field col s12">

				<i class="fa fa-briefcase prefix"></i>

				{!! Form::textarea('o_details',null,['id' => 'o_details','class' => 'materialize-textarea']) !!}

				<label for="o_details">Opening Details *</label>


			</div>

		</div>


		<div class="row">

			<div class="input-field col s12">

				<i class="fa fa-mortar-board prefix"></i>

				{!! Form::textarea('eligibility',null,['id' => 'eligibility','class' => 'materialize-textarea']) !!}

				<label for="eligibility">Eligibility Criteria *</label>


			</div>

		</div>


		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-users prefix"></i>

				{!! Form::number('intake_cap',null,['id' => 'intake_cap', 'required' => 'required']) !!}

				<label for="intake_cap"> Intake Capacity *</label>

			</div>

			<div class="input-field col s12 l6">

				<i class="mdi-communication-phone prefix"></i>

				{!! Form::number('contact',null,['id' => 'contact','required' => 'required']) !!}

				<label for="contact">Phone number of contact person *</label>

			</div>

		</div>


		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-money prefix"></i>

				{!! Form::number('max_salary',null,['id' => 'max_salary', 'required' => 'required']) !!}

				<label for="max_salary"> Max. Salary *</label>

			</div>

			<div class="input-field col s12 l6">

				<i class="fa fa-money prefix"></i>

				{!! Form::number('min_salary',null,['id' => 'min_salary','required' => 'required']) !!}

				<label for="min_salary"> Min. Salary *</label>

			</div>

		</div>


		<div class="row">

			<div class="input-field col s12 l12">

				{!! Form::select('is_active',['1' => 'Enable', '0' => 'Disable'],$data->is_active) !!}

			</div>

		</div>



			<div class="row">

				<div class="input-field col s12">

					<div class="input-field col s12">

						<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit <i class="mdi-content-send right"></i></button>

					</div>

				</div>

			</div>


	</div>

</div>