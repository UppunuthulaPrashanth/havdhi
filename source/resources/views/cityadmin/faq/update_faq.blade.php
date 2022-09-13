@extends('cityadmin.layout.app')

@section ('content')


        <div class="content-wrapper">
          <div class="row">
            
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update FAQs</h4>
                  @if (count($errors) > 0)
                      @if($errors->any())
                        <div class="alert alert-primary" role="alert">
                          {{$errors->first()}}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                      @endif
                  @endif
                  <form class="forms-sample" action="{{route('faq_edit', [$faq->faq_id])}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="form-group">
                      <label for="exampleInputName1">Question</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="question" placeholder="FAQ Question" value="{{$faq->question}}">
                    </div>
                      @foreach($lang as $langs)
                              <?php $tex2 = $langs->lang_prefix.'_question' ?>
                     <div class="form-group">
                      <label for="exampleInputName1">FAQ question in {{$langs->lang_name}}<sup>*</sup></label>
                      <input type="text" class="typeahead form-control" id="exampleInputName1" name="{{$tex2}}" value="{{$faq->$tex2}}" required>
                    </div>
                    @endforeach
                    
                    <div class="form-group">
                      <label for="exampleInputName1">Answer</label>
                      <textarea type="text" class="form-control" id="exampleInputName1" row="5" name="answer">{{$faq->answer}}</textarea>
                    </div>
                     @foreach($lang as $langs)
                              <?php $tex = $langs->lang_prefix.'_answer' ?>
                     <div class="form-group">
                      <label for="exampleInputName1">FAQ answer in {{$langs->lang_name}}<sup>*</sup></label>
                     
                      <textarea type="text" class="form-control" row="5" id="exampleInputName1" name="{{$tex}}" required>{{$faq->$tex}}</textarea>
                    </div>
                    @endforeach
                   
                    <button type="submit" class="btn btn-success mr-2">Save</button>
                    <a href="{{route('faq_list')}}" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
            </div>

     
          </div>
        </div>
</div>
 @endsection