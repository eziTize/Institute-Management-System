
<div class="col s12 m12 l12">

	<div class="card-panel">

		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-info prefix"></i>

				{!! Form::text('sm_name',null,['id' => 'sm_name','required' => 'required']) !!}

				<label for="sm_name">Guest Lecturer Name *</label>

			</div>



			<div class="input-field col s12 l6">

				<i class="fa fa-calendar prefix"></i>

				{!! Form::date('date',null,['id' => 'date','required' => 'required', 'class' => 'datepicker' ]) !!}

        		<label for="date">Guest Lecture Date *</label>

			</div>

		</div>



		<div class="row">

			<div class="input-field col s12">

				<i class="fa fa-flag prefix"></i>

				{!! Form::text('t_plan',null,['id' => 't_plan','required' => 'required']) !!}

				<label for="t_plan">Topic of the lecture *</label>

			</div>

		</div>

		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-money prefix"></i>

				{!! Form::number('budget', null,['id' => 'budget','required' => 'required']) !!}

				<label for="budget">Budget of the Guest Lecture (Rs) *</label>

			</div>


			<div class="input-field col s12 l6">

				<i class="fa fa-money prefix"></i>

				{!! Form::number('expense', null,['id' => 'expense','required' => 'required']) !!}

				<label for="expense"> Guest Lecturer Expense (Rs) *</label>

			</div>


		</div>


		<div class="row">


			<div class="input-field col s12">

				<i class="mdi-communication-phone prefix"></i>

				{!! Form::number('ph_no',null,['id' => 'ph_no','required' => 'required']) !!}

				<label for="ph_no">Phone number of the Guest Lecturer *</label>

			</div>

		</div>


		<div class="row">

			<div class="input-field col s12">

				<i class="fa fa-comment prefix"></i>

				{!! Form::text('remarks',null,['id' => 'remarks']) !!}

				<label for="remarks">Remarks (if any) </label>

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