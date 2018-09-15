@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <form method="POST" action="{{ route('assess') }}" aria-label="{{ __('Login') }}">
            @csrf

            <input type="hidden" id="company_id" name="company_id" value="{{$company_id}}">
            <input type="hidden" id="student_id" name="student_id" value="{{$student_id}}">
            <input type="hidden" id="id" name="id" value="{{isset($result) ? $result->id : '' }}">

            <div class="row bg-dark text-light">
                <h1>
                    Assessment
                </h1>
            </div>

            <div class="form-group row bg-dark text-light">
                <label class="col-sm-12 text-center text-justify">
                    <strong>
                        Please rate the practicumer using the scale below: <br>
                        5 = Excellent<br>
                        4 = Very Good<br>
                        3 = Good<br>
                        2 = Fair<br>
                        1 = Poor
                    </strong>
                </label>

                <div class="col-md-12">
                    <hr>
                    <h5> 1. Personal Characteristics </h5>
                    <div class="row">
                        <div class="col-sm-12">
                            1.1 Dresses neatly and appropriately for office work
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="1_1" id="1_1">
                                <option value="1" {{isset($result) ? ($result->{'1_1'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'1_1'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'1_1'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'1_1'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'1_1'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            1.2 Has a pleasing personality, is cheerful and good humored
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="1_2" id="1_2">
                                <option value="1" {{isset($result) ? ($result->{'1_2'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'1_2'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'1_2'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'1_2'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'1_2'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            1.3 Possesses above average oral and written communication skills
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="1_3" id="1_3">
                                <option value="1" {{isset($result) ? ($result->{'1_3'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'1_3'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'1_3'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'1_3'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'1_3'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            1.4 Project self-confidence and enthusiasm
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="1_4" id="1_4">
                                <option value="1" {{isset($result) ? ($result->{'1_4'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'1_4'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'1_4'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'1_4'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'1_4'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            1.5 Demonstrates leadership potential
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="1_5" id="1_5">
                                <option value="1" {{isset($result) ? ($result->{'1_5'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'1_5'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'1_5'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'1_5'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'1_5'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            Comments
                        </div>

                        <div class="col-sm-12">
                            <textarea name="1_comments" id="1_comments" required>{{isset($result) ? $result->{'1_comments'} : '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                    <h5> 2. Attitude towards the job </h5>
                    <div class="row">
                        <div class="col-sm-12">
                            2.1 Shows marked interest and pride
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="2_1" id="2_1">
                                <option value="1" {{isset($result) ? ($result->{'2_1'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'2_1'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'2_1'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'2_1'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'2_1'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            2.2 Has an exceptional sense of duty and can always be depended upon to do a good job
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="2_2" id="2_2">
                                <option value="1" {{isset($result) ? ($result->{'2_2'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'2_2'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'2_2'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'2_2'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'2_2'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            2.3 Cooperates willingly and fits easily to the group
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="2_3" id="2_3">
                                <option value="1" {{isset($result) ? ($result->{'2_3'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'2_3'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'2_3'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'2_3'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'2_3'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            2.4 Recognizes the authority and responsibilities of his/her superiors and provide them with the necessary support services and assistance required or sought
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="2_4" id="2_4">
                                <option value="1" {{isset($result) ? ($result->{'2_4'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'2_4'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'2_4'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'2_4'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'2_4'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            2.5 Takes initiatives to update one’s technical and/or non-technical knowledge and skills
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="2_5" id="2_5">
                                <option value="1" {{isset($result) ? ($result->{'2_5'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'2_5'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'2_5'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'2_5'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'2_5'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            Comments
                        </div>

                        <div class="col-sm-12">
                            <textarea name="2_comments" id="2_comments" required>{{isset($result) ? $result->{'2_comments'} : '' }}</textarea>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <hr>
                    <h5> 3. Job Performance </h5>
                    <div class="row">
                        <div class="col-sm-12">
                            3.1 Delivers promptly assigned task/ responsibilities
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="3_1" id="3_1">
                                <option value="1" {{isset($result) ? ($result->{'3_1'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'3_1'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'3_1'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'3_1'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'3_1'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            3.2 Performs assigned tasks with minimum supervision
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="3_2" id="3_2">
                                <option value="1" {{isset($result) ? ($result->{'3_2'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'3_2'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'3_2'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'3_2'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'3_2'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            3.3 Willingly accepts work assignments and/ or responsibilities
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="3_3" id="3_3">
                                <option value="1" {{isset($result) ? ($result->{'3_3'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'3_3'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'3_3'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'3_3'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'3_3'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            3.4 Delivers assigned tasks within acceptable level of quality
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="3_4" id="3_4">
                                <option value="1" {{isset($result) ? ($result->{'3_4'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'3_4'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'3_4'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'3_4'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'3_4'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            3.5 Performs assigned tasks in an organized and orderly manner
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="3_5" id="3_5">
                                <option value="1" {{isset($result) ? ($result->{'3_5'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'3_5'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'3_5'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'3_5'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'3_5'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            3.6 Exhibits ability to function well even under pressure
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="3_6" id="3_6">
                                <option value="1" {{isset($result) ? ($result->{'3_6'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'3_6'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'3_6'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'3_6'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'3_6'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            Comments
                        </div>

                        <div class="col-sm-12">
                            <textarea name="3_comments" id="3_comments" required>{{isset($result) ? $result->{'3_comments'} : '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                    <h5> 4. Adherence to Company Policies   </h5>
                    <div class="row">
                        <div class="col-sm-12">
                            4.1 Present at work most of the time
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="4_1" id="4_1">
                                <option value="1" {{isset($result) ? ($result->{'4_1'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'4_1'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'4_1'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'4_1'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'4_1'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            4.2 Comes to work on time
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="4_2" id="4_2">
                                <option value="1" {{isset($result) ? ($result->{'4_2'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'4_2'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'4_2'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'4_2'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'4_1'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            4.3 Adheres to company and regulations
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="4_3" id="4_3">
                                <option value="1" {{isset($result) ? ($result->{'4_3'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'4_3'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'4_3'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'4_3'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'4_3'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            Comments
                        </div>

                        <div class="col-sm-12">
                            <textarea name="4_comments" id="4_comments" required>{{isset($result) ? $result->{'4_comments'} : '' }}</textarea>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <hr>
                    <h5> 5. Competence </h5>
                    <div class="row">
                        <div class="col-sm-12">
                            5.1 Shows mastery of generally accepted principles relevant to the course as applied to different situations.
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="5_1" id="5_1">
                                <option value="1" {{isset($result) ? ($result->{'5_1'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'5_1'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'5_1'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'5_1'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'5_1'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            5.2 Shows adequate knowledge and skills in performing assigned tasks.
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="5_2" id="5_2">
                                <option value="1" {{isset($result) ? ($result->{'5_2'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'5_2'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'5_2'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'5_2'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'5_2'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            5.3 Shows ability to perform routine office procedures.
                        </div>

                        <div class="col-sm-12">
                             <select style="width: 100px;"name="5_3" id="5_3">
                                <option value="1" {{isset($result) ? ($result->{'5_3'} == '1' ? 'selected' : '') : 'selected' }}>1</option>
                                <option value="2" {{isset($result) ? ($result->{'5_3'} == '2' ? 'selected' : '') : '' }}>2</option>
                                <option value="3" {{isset($result) ? ($result->{'5_3'} == '3' ? 'selected' : '') : '' }}>3</option>
                                <option value="4" {{isset($result) ? ($result->{'5_3'} == '4' ? 'selected' : '') : '' }}>4</option>
                                <option value="5" {{isset($result) ? ($result->{'5_3'} == '5' ? 'selected' : '') : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            Comments
                        </div>

                        <div class="col-sm-12">
                            <textarea name="5_comments" id="5_comments" required>{{isset($result) ? $result->{'5_comments'} : '' }}</textarea>
                        </div>
                    </div>
                </div>



            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection
