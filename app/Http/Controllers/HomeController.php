<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Favorite;
use App\Models\Hotel;
use App\Models\Rating;
use App\Models\Room;
use App\Models\RoomAmenities;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $per_page = empty($request->per_page) ? 10 : $request->per_page;
        return response()->json(array(
            "code" => 200,
            "message" => "SUCCESS",
            "result"=> Hotel::with("manager")->with("hotel_images")->where(function($query) use ($request){
                if (!empty($request->keyword)) $query->where("name", "ilike", "%".$request->keyword."%");
            })
            ->with("manager")->when(!empty($request->sort), function ($query) use ($request){
                    $explode = explode(":", $request->sort);
                    $query->orderBy($explode[0],$explode[1]);
                })
            ->paginate($per_page)
        ), ResponseStatus::HTTP_OK);
    }

    public function city ()
    {
        $cities=Hotel::select('city')->get();
        return response()->json(array(
            "code" => 200,
            "message" => "SUCCESS",
            "result"=>$cities
        ),ResponseStatus::HTTP_OK);
    }

    public function search(Request $request)
    {
        $bookings=Booking::select('room_id')
        ->where('check_in','>=',date('Y-m-d 14:00:00',strtotime($request->check_in)))
        ->where('check_out','>=',date('Y-m-d 14:00:00'))
        ->get()->toArray();

        $rooms=DB::table('rooms')->whereNotIn('rooms.id', $bookings)->get();
        // $results['counts']=count($rooms);
        foreach($rooms as $room){
            $hotel=Hotel::find($room->hotel_id);
            $room_type=RoomType::find($room->rooms_type_id);
            $room_amn=DB::table('room_amenities')->select('amenities.*')
            ->leftJoin('amenities','amenities.id','room_amenities.amenities_id')
            ->where('room_id',$room->id)->get();
            $rating=Rating::where('hotel_id',$hotel->id)->avg('rate');
            $results[]=[
                'id'=>$room->id,
                'hotel_name'=>$hotel->name,
                'hotel_city'=>$hotel->city,
                'hotel_address'=>$hotel->address,
                'hotel_latitude'=>$hotel->latitude,
                'hotel_longitude'=>$hotel->longitude,
                'hotel_rating'=>$rating,
                'room_image'=>$room->featured_image,
                'room_type'=>$room_type->type_name,
                'room_amenities'=>$room_amn,
            ];
        }
        return response()->json(array(
            "code" => 200,
            "message" => "SUCCESS",
            "result"=>$results
        ),ResponseStatus::HTTP_OK);
    }

    public function detail(Request $request)
    {
        $room=DB::table('rooms')->where('rooms.id', $request->id)->first();
        // $results['counts']=count($rooms);
        $hotel=Hotel::find($room->hotel_id);
        $room_type=RoomType::find($room->rooms_type_id);
        $room_amn=DB::table('room_amenities')->select('amenities.*')
        ->leftJoin('amenities','amenities.id','room_amenities.amenities_id')
        ->where('room_id',$room->id)->get();
        $rating=Rating::where('hotel_id',$hotel->id)->avg('rate');
        $count_rating=Rating::where('hotel_id',$hotel->id)->count('rate');
        $results=[
            'hotel_name'=>$hotel->name,
            'hotel_city'=>$hotel->city,
            'hotel_address'=>$hotel->address,
            'hotel_latitude'=>$hotel->latitude,
            'hotel_longitude'=>$hotel->longitude,
            'hotel_rating'=>$rating,
            'count_rating'=>$count_rating,
            'room_name'=>$room->title,
            'room_description'=>$room->description,
            'room_image'=>$room->featured_image,
            'room_type'=>$room_type->type_name,
            'room_amenities'=>$room_amn,
        ];
        
        return response()->json(array(
            "code" => 200,
            "message" => "SUCCESS",
            "result"=>$results
        ),ResponseStatus::HTTP_OK);
    }

    public function favorites(Request $request)
    {
        // $request->auth_id
        $favorites=Favorite::select('hotel.*')
        ->leftJoin('hotel','hotel.id','favorites.hotel_id')
        ->where('user_id',$request->auth_id)->get();
        return response()->json(array(
            "code" => 200,
            "message" => "SUCCESS",
            "result"=>$favorites
        ),ResponseStatus::HTTP_OK);
    }

    public function add_favorite(Request $request)
    {
        $favorite=DB::table('favorites')
        ->updateOrInsert(
            ['hotel_id' => $request->hotel_id, 'user_id' => $request->auth_id],
            ['created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]
        );
        $hotel=Hotel::find($request->hotel_id);
        return response()->json(array(
            "code" => 200,
            "message" => "SUCCESS",
            "result"=>$hotel
        ),ResponseStatus::HTTP_OK);

    }

    public function rmv_favorite(Request $request)
    {
        $favorite = DB::table('favorites')
        ->where('hotel_id', $request->hotel_id)
        ->where('user_id', $request->auth_id)
        ->delete();

        return response()->json(array(
            "code" => 200,
            "message" => "SUCCESS",
            "result"=>$favorite
        ),ResponseStatus::HTTP_OK);

    }

}
