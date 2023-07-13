 @extends('admin.admin_master')

 @section('admin')
     <div class="page-content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-12">
                     <div class="card">
                         <div class="card-body">
                             @if (session('status'))
                                 <div class="alert alert-success">
                                     {{ session('status') }}
                                 </div>
                             @endif
                             <div class="row mb-5">
                                 <h4 class="mt-2 mb-3">Site Information</h4>
                                 <form method="POST" action="{{ route('store.company') }}" enctype="multipart/form-data">
                                     @csrf
                                     <div class="row">
                                         <div class="col-12">
                                             <label for="example-text-input" class="form-label">Site Logo</label>
                                             <div class="feature-image">
                                                 <div class="site-info-img">
                                                     <label for="feature-img">
                                                         <div class="col-sm-12 img">
                                                             <i class="fas fa-upload"></i>
                                                             <p>Choose logo</p><span>(max-size:2MB)</span>
                                                         </div>
                                                     </label>
                                                     <input type="file" id="feature-img" name="logo"
                                                         style="display: none; visibility:none" onchange="loadFile(event)">
                                                     <div class="row mb-3 site-show-img">
                                                         <img id="socialOutPut" class="rounded avatar-lg"
                                                             src="{{ url('upload/no_image.jpg') }}" alt="Card image cap"
                                                             style="width: 100%">
                                                     </div>
                                                     @error('logo')
                                                         <div class="alert alert-danger mt-1 mb-1">
                                                             {{ $message }}</div>
                                                     @enderror
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-md-12 mt-5">
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">Site title&nbsp; <span
                                                                 class="fi fi-us"></span> (EN)</label>
                                                         <input type="text" name="en_name" class="form-control"
                                                             placeholder="site title" value="{{ old('en_name') }}">
                                                         @error('name')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">Site title&nbsp; <span
                                                                 class="fi fi-la"></span> (LA)</label>
                                                         <input type="text" name="la_name" class="form-control"
                                                             placeholder="site title" value="{{ old('la_name') }}">
                                                         @error('name')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">Email</label>
                                                         <input type="email" name="email" class="form-control"
                                                             placeholder="example@gmail.com" value="{{ old('email') }}">

                                                         @error('email')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">Website</label>
                                                         <input type="text" name="website" class="form-control"
                                                             placeholder="www.example.com" value="{{ old('website') }}">

                                                         @error('website')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">Mobile</label>
                                                         <input type="phone" name="mobile" class="form-control"
                                                             placeholder="20xxxxxxxx" value="{{ old('mobile') }}">

                                                         @error('mobile')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">Telephone</label>
                                                         <input type="phone" name="telephone" class="form-control"
                                                             placeholder="021xxxxxxx" value="{{ old('telephone') }}">

                                                         @error('telephone')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">Fax</label>
                                                         <input type="phone" name="fax" class="form-control"
                                                             placeholder="021xxxxxxx" value="{{ old('fax') }}">

                                                         @error('fax')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>

                                             </div>
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">Address&nbsp; <span
                                                                 class="fi fi-us"></span> (EN)</label>
                                                         <input type="text" name="en_address" class="form-control"
                                                             placeholder="site title" value="{{ old('en_address') }}">
                                                         @error('name')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">Address&nbsp;
                                                             <span class="fi fi-la"></span> (LA)</label>
                                                         <input type="text" name="la_address" class="form-control"
                                                             placeholder="site title" value="{{ old('la_address') }}">
                                                         @error('name')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row mt-2">
                                                 <div class="col-md-12">
                                                     <label for="example-text-input" class="form-label">About description
                                                         &nbsp;
                                                         <span class="fi fi-us"></span>&nbsp;(EN)</label>
                                                     @error('address')
                                                         <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                     @enderror
                                                     <div class="col-md-12 col-sm-12">
                                                         <textarea id="elm1" name="en_about">{{ old('en_about') }}</textarea>
                                                     </div>
                                                 </div>
                                                 <div class="col-md-12">
                                                     <label for="example-text-input" class="form-label">About description
                                                         &nbsp; <span class="fi fi-la"></span>&nbsp;(LA)</label>
                                                     @error('address')
                                                         <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                     @enderror
                                                     <div class="col-md-12 col-sm-12">
                                                         <textarea id="elm2" name="la_about">{{ old('la_about') }}</textarea>
                                                     </div>
                                                 </div>
                                             </div>
                                             @if (Auth::user()->can('siteInfo.insert'))
                                                 <div>
                                                     <button type="submit" class="btn btn-success my-lg-5"
                                                         style="width: 25%">&nbsp;<i
                                                             class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Save</button>
                                                 </div>
                                             @endif
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
