<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>

    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Enroll Student</h5>

              <form id="frmEnrollStudent" method="post" action="<?= base_url(); ?>index.php/enrollments/enroll_student">

                <hr>
                <div id="personalDetails">
                  <h6>Personal Details</h6>
                  <hr>

                  <div class="form-row">
                    <div class="form-group col-md-1">
                      <label>Title <span class="required">*</span></label>
                      <select class="form-control form-control-sm" name="title" id="title" required>
                        <option value="">- Select -</option>
                        <option value="Mr">Mr</option>
                        <option value="Miss">Miss</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Dr">Dr</option>
                        <option value="Rev">Rev</option>
                      </select>
                    </div>
                    <div class="form-group col-md-5">
                      <label>Name with Initials <span class="required">*</span></label>
                      <input type="text" id="initials_name" name="initials_name" class="form-control form-control-sm" placeholder="R.A.I.S. RANASINGHE" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Full Name <span class="required">*</span></label>
                      <input type="text" id="full_name" name="full_name" class="form-control form-control-sm" placeholder="RANASINGHE ARACHCHIGE ISURU SANDEEPA RANASINGHE" required>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Date of Birth <span class="required">*</span></label>
                      <input type="text" id="dob" name="dob" class="form-control form-control-sm" placeholder="1997-12-22" required>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Gender <span class="required">*</span></label>
                      <select id="gender" name="gender" class="form-control form-control-sm" required>
                        <option value="">-- Please Select --</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label>NIC / Passport Number <span class="required">*</span></label>
                      <input type="text" id="nic" name="nic" class="form-control form-control-sm" placeholder="974671480V" required>
                      <div class="validation-feedback" id="nic_validation"></div>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Nationality <span class="required">*</span></label>
                      <input type="text" id="nationality" name="nationality" class="form-control form-control-sm" placeholder="SRI LANKAN" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Address <span class="required">*</span></label>
                      <input type="text" id="address" value="<?php if(!empty($inquiry_details)) { echo $inquiry_details['address']; } ?>" name="address" class="form-control form-control-sm" placeholder="3A/228, HOUSINGHE SCHEME" required>
                    </div>
                    <div class="form-group col-md-3">
                      <label>City <span class="required">*</span></label>
                      <input type="text" id="city" value="<?php if(!empty($inquiry_details)) { echo $inquiry_details['city']; } ?>" name="city" class="form-control form-control-sm" placeholder="NUGEGODA" required>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Country <span class="required">*</span></label>
                      <select id="country" name="country" class="form-control form-control-sm" required>
                        <option value="">-- Please Select --</option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Åland Islands">Åland Islands</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antarctica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Bouvet Island">Bouvet Island</option>
                        <option value="Brazil">Brazil</option>
                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Christmas Island">Christmas Island</option>
                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Cote D'ivoire">Cote D'ivoire</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="French Southern Territories">French Southern Territories</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guernsey">Guernsey</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-bissau">Guinea-bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Isle of Man">Isle of Man</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jersey">Jersey</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                        <option value="Korea, Republic of">Korea, Republic of</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macao">Macao</option>
                        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                        <option value="Moldova, Republic of">Moldova, Republic of</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Pitcairn">Pitcairn</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Reunion">Reunion</option>
                        <option value="Romania">Romania</option>
                        <option value="Russian Federation">Russian Federation</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Saint Helena">Saint Helena</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                        <option value="Saint Lucia">Saint Lucia</option>
                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                        <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Serbia">Serbia</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                        <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Timor-leste">Timor-leste</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Viet Nam">Viet Nam</option>
                        <option value="Virgin Islands, British">Virgin Islands, British</option>
                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                        <option value="Western Sahara">Western Sahara</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Mobile Number <span class="required">*</span></label>
                      <input type="text" value="0<?php if(!empty($inquiry_details)) { echo $inquiry_details['mobile']; } ?>" id="mobile" name="mobile" class="form-control form-control-sm" placeholder="0770430000" required>
                      <div class="validation-feedback" id="mobile_validation"></div>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Home Number <span class="required">*</span></label>
                      <input type="text" id="home" value="0<?php if(!empty($inquiry_details)) { echo $inquiry_details['home']; } ?>" name="home" class="form-control form-control-sm" placeholder="0117430000" required>
                      <div class="validation-feedback" id="home_validation"></div>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Email <span class="required">*</span></label>
                      <input type="email" id="email" name="email" class="form-control form-control-sm" placeholder="info@saegis.edu.lk" required>
                    </div>
                  </div>
                  <hr>
                </div>

                <div id="educationDetails">
                  <h6>Educational Details</h6>
                  <hr>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label>Schools <span class="required">*</span></label>
                      <textarea class="form-control" name="schools" id="schools">
                      </textarea>
                    </div>
                    <div class="form-group col-md-4">
                      <label>G.C.E. O/L <span class="required">*</span></label>
                      <input type="text" id="ol" name="ol" class="form-control form-control-sm" placeholder="7A, 2B" required>
                    </div>
                    <div class="form-group col-md-2">
                      <label>Year <span class="required">*</span></label>
                      <input type="text" id="ol_year" name="ol_year" class="form-control form-control-sm" placeholder="2013" required>
                    </div>
                    <div class="form-group col-md-2">
                      <label>G.C.E. A/L <span class="required">*</span></label>
                      <input type="text" id="al" name="al" class="form-control form-control-sm" placeholder="1A, 2B" required>
                    </div>
                    <div class="form-group col-md-2">
                      <label>Stream <span class="required">*</span></label>
                      <select id="stream" name="stream" class="form-control form-control-sm" required>
                        <option value="">-- Please Select --</option>
                        <option value="Biology">Biology</option>
                        <option value="Commerce">Commerce</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Arts">Arts</option>
                        <option value="Technology">Technology</option>
                      </select>
                    </div>
                    <div class="form-group col-md-2">
                      <label>Year <span class="required">*</span></label>
                      <input type="text" id="al_year" name="al_year" class="form-control form-control-sm" placeholder="2016" required>
                    </div>
                    <div class="form-group col-md-12">
                      <label>Other Educational Qualifications</label>
                      <textarea class="form-control" name="other_edu" id="other_edu">
                      </textarea>
                    </div>
                  </div>
                  <hr>
                </div>

                <div id="guardianDetails">
                  <h6>Guardian Details</h6>
                  <hr>

                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label>Emergency Contact Name <span class="required">*</span></label>
                      <input type="text" id="guardian_name" name="guardian_name" class="form-control form-control-sm" placeholder="R.A.RANASINGHE" required>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Relationship <span class="required">*</span></label>
                      <input type="text" id="relationship" name="relationship" class="form-control form-control-sm" placeholder="FATHER" required>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Mobile Number <span class="required">*</span></label>
                      <input type="text" id="guardian_mobile" name="guardian_mobile" class="form-control form-control-sm" placeholder="0770430000" required>
                      <div class="validation-feedback" id="guardian_validation"></div>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Home Number</label>
                      <input type="text" id="guardian_home" name="guardian_home" class="form-control form-control-sm" placeholder="0117430000">
                    </div>
                  </div>

                  <hr>
                  <h6>Enrollment Details</h6>
                  <hr>

                  <div class="form-row">
                    <div class="form-group col-md-1">
                      <label>Inquiry ID</label>
                      <input type="text" id="inquiryId" name="inquiryId" value="<?php if(!empty($inquiry_details)) { echo $inquiry_details['id']; } ?>" class="form-control form-control-sm" placeholder="" readonly>
                    </div>
                    <div class="form-group col-md-1">
                      <label>Student ID</label>
                      <input type="text" id="studentId" name="studentId" class="form-control form-control-sm" placeholder="">
                    </div>
                    <div class="form-group col-md-2">
                      <label>Intake <span class="required">*</span></label>
                      <select id="intakeId" name="intakeId" class="form-control form-control-sm" required>
                        <?php foreach($intakes as $intake) { ?>
                          <option value="<?= $intake['id']; ?>"><?= $intake['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Course <span class="required">*</span></label>
                      <select id="courseId" name="courseId" class="form-control form-control-sm" required>
                        <option value="<?php if(!empty($inquiry_details)) { echo $inquiry_details['course']; } ?>"><?php if(!empty($inquiry_details)) { echo $inquiry_details['courseName']; } ?></option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Payment Plan <span class="required">*</span></label>
                      <select id="pplanId" name="pplanId" class="form-control form-control-sm" required>
                        <option value="">-- Please Select --</option>
                      </select>
                    </div>
                    <div class="form-group col-md-2">
                      <label>Batch <span class="required">*</span></label>
                      <select id="batchId" name="batchId" class="form-control form-control-sm" required>
                        <option value="">-- Please Select --</option>
                      </select>
                    </div>
                    <div class="form-group col-md-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="birth_certificate" id="birth_certificate">
                        <label class="form-check-label" for="invalidCheck2">
                          Birth Certificate
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="ol_certificate" id="ol_certificate">
                        <label class="form-check-label" for="invalidCheck2">
                          G.C.E. O/L Certificate
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="al_certificate" id="al_certificate">
                        <label class="form-check-label" for="invalidCheck2">
                          G.C.E. A/L Certificate
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="nic_copy" id="nic_copy">
                        <label class="form-check-label" for="invalidCheck2">
                          A Copy of National ID Card / Passport
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="other_certificates" id="other_certificates">
                        <label class="form-check-label" for="invalidCheck2">
                          Other Qualification Certificates / Transcripts
                        </label>
                      </div>
                    </div>
                    <br>
                    <div class="form-group col-md-12">
                      <label>Remarks</label>
                      <textarea class="form-control" name="remarks" id="remarks">
                      </textarea>
                    </div>
                    <div class="col align-self-end">
                      <button type="submit" class="btn btn-primary btn-sm">Enroll Student</button>
                    </div>
                  </div>
                </div>

              <?php echo form_close(); ?>
            </div>
          </div>
      </div>
    </div>
</div>

<script>
$(function() {
  $('#dob').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10),
    locale: {
      format: 'YYYY-MM-DD'
    }
  });
});

$(document).ready(function(){

  get_pplan($('#courseId').val(),$('#intakeId').val());
  get_batches_by_course($('#courseId').val());

  $('#frmEnrollStudent').submit(function(e){

    var re = /[0-9]{2}\d{8}/;

    var mobile_flag;
    var home_flag;
    var guardian_flag;
    var nic_flag;

    var nic = $('#nic').val();
    var mobile = $('#mobile').val();
    var home = $('#home').val();
    var guardian_mobile = $('#guardian_mobile').val();

    if(validate_nic===true) {
      $('#nic').removeClass('is-valid');
      $('#nic').addClass('is-invalid');
      $('#nic_validation').show();
      $('#nic_validation').addClass('invalid-feedback');
      $('#nic_validation').html('This student is an existing student of the Campus. If you wish to enroll this student again, please visit here.');
      nic_flag = 0;
      e.preventDefault();
    } else {
      nic_flag = 1;
      $('#nic').removeClass('is-invalid');
      $('#nic').addClass('is-valid');
      $('#nic_validation').hide();
    }

    if(!re.test(mobile)) {
      $('#mobile').removeClass('is-valid');
      $('#mobile').addClass('is-invalid');
      $('#mobile_validation').show();
      $('#mobile_validation').addClass('invalid-feedback');
      $('#mobile_validation').html('Mobile number is not valid.');
      e.preventDefault();
      mobile_flag = 0;
    } else {
      $('#mobile').removeClass('is-invalid');
      $('#mobile').addClass('is-valid');
      $('#mobile_validation').hide();
      mobile_flag = 1;
    }

    if(!re.test(home)) {
      $('#home').removeClass('is-valid');
      $('#home').addClass('is-invalid');
      $('#home_validation').show();
      $('#home_validation').addClass('invalid-feedback');
      $('#home_validation').html('Home number is not valid.');
      home_flag = 0;
      e.preventDefault();
    } else {
      $('#home').removeClass('is-invalid');
      $('#home').addClass('is-valid');
      $('#home_validation').hide();
      home_flag = 1;
    }

    if(!re.test(guardian_mobile)) {
      $('#guardian_mobile').removeClass('is-valid');
      $('#guardian_mobile').addClass('is-invalid');
      $('#guardian_validation').show();
      $('#guardian_validation').addClass('invalid-feedback');
      $('#guardian_validation').html('Mobile number is not valid.');
      guardian_flag = 0
      e.preventDefault();
    } else {
      $('#guardian_mobile').removeClass('is-invalid');
      $('#guardian_mobile').addClass('is-valid');
      $('#guardian_validation').show();
      guardian_flag = 1;
    }

    if(nic_flag==1 && home_flag==1 && mobile_flag==1 && guardian_flag==1) {
      $('#frmEnrollStudent').submit();
     //  var form = $('#frmEnrollStudent');
     //  $.ajax({
     //   type: "POST",
     //   url: '<?php //echo base_url(); ?>index.php/enrollments/enroll_student',
     //   data: form.serialize(),
     //   success: function(response) {
     //     if(response=='success') {
     //       console.log('student added')
     //     } else {
     //       console.log('response');
     //     }
     //   }
     // });
    }

  });

  $('#intakeId').change(function() {
    get_pplan($('#courseId').val(),$('#intakeId').val());
    get_batches_by_course($('#courseId').val());
  });

  $('#courseId').change(function() {
    get_pplan($('#courseId').val(),$('#intakeId').val());
    get_batches_by_course($('#courseId').val());
  });

});

function validate_nic(nic) {
  $.ajax({
   type: "POST",
   url: '<?php echo base_url(); ?>index.php/enrollments/validate_nic',
   data: { nic:nic},
   success: function(response) {
     if(response=='success') {
       return true;
     }
   }
 });
}

function get_pplan(courseId,intakeId){
  $.blockUI();
  $('#pplanId').empty();
  $.ajax({
   type: "POST",
   url: '<?php echo base_url(); ?>index.php/payments/get_payment_plans_by_intake_course',
   data: { courseId:courseId, intakeId:intakeId },
   success: function(response) {
     $.each(response,function(key, val) {
       $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#pplanId');
     });
     $.unblockUI();
   }
 });
}

 function get_batches_by_course(courseId) {
   $('#batchId').empty();
   $.blockUI();
   $.ajax({
       type : "GET",
       //set the data type
       url: '<?php echo base_url(); ?>index.php/batches/get_batches_by_course_active', // target element(s) to be updated with server response
       data: {courseId:courseId},
       cache : false,
       //check this in Firefox browser
       success : function(response){
           $.each(response,function(key, val) {
               $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#batchId');
           });
           $.unblockUI();
       }
   });
 }

</script>
