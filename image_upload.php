<?php 

  public function avatar(Request $request){
        $userId = Auth::guard()->user()->id;
        $user = User::findOrFail($userId);

        if($request->hasFile('avatar')) {
            if ($user->avatar){
                unlink(public_path('/avatar/').$user->avatar);
            }
            $avatar = $request->file('avatar');
            $avatarName = $avatar->getClientOriginalName();
            $fileName = "user_" . "_id_". Auth::guard()->user()->id . "_" . $avatarName;

            $directory = public_path('/avatar/');
            $avatarUrl = $directory.$fileName;
            Image::make($avatar)->resize(565, 565)->save($avatarUrl);
            $user->avatar = $fileName;
        }

        if ($user->save())
            return redirect()->back()->with('success','Update successfully');

        return redirect()->back()->with('error', 'There is an error message');
    }

