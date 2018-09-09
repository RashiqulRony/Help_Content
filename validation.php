<?php

        $data = $request->all();
        $validator = Validator::make($data, [
            'project_title' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


?>
