<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataItem;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function uplode(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,json'
        ]);

        $data = [];
        $file = $request->file('file');

        if ($file->getClientOriginalExtension() === 'json') {
            $data = json_decode(file_get_contents($file), true);
        } else {
            $data = Excel::toArray([], $file)[0]; 
        }
        $headerSkipped = false;

        foreach ($data as $row) {
            if (!$headerSkipped) {
                $headerSkipped = true;
                continue;
            }

            if (!empty($row[0])) {
                DataItem::create([
                    'name'          => $row['name']          ?? $row[0] ?? null,
                    'email'         => $row['email']         ?? $row[1] ?? null,
                    'phone'         => $row['phone']         ?? $row[2] ?? null,
                    'dob'           => $row['dob']           ?? $row[3] ?? null,
                    'registered_at' => $row['registered_at'] ?? $row[4] ?? null,
                    'is_active'     => $row['is_active']     ?? $row[5] ?? null,
                    'balance'       => $row['balance']       ?? $row[6] ?? null,
                    'parent_id'     => $row['parent_id']     ?? $row[7] ?? null,
                ]);
            }
        }

        return response()->json(['message' => 'Imported successfully']);
    }

}
