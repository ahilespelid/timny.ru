<?php

use App\Http\Controllers\Admin\MentorController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\ApiControllers\SettingsController;
use App\Http\Controllers\ApiControllers\TermsConditionsController;
use App\Http\Controllers\ApiControllers\TestinomialsController;
use App\Http\Controllers\Front\AppointmentBookingController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\ChatController;
use App\Http\Controllers\Front\ContactUsController;
use App\Http\Controllers\Front\CountryController;
use App\Http\Controllers\Front\JazzcashGatewayController;
use App\Http\Controllers\Front\MenteeProfileController;
use App\Http\Controllers\Front\MentorCardController;
use App\Http\Controllers\Front\MentorCategoryController;
use App\Http\Controllers\Front\MentorDegreeController;
use App\Http\Controllers\Front\MentorEducationController;
use App\Http\Controllers\Front\MentorExperienceController;
use App\Http\Controllers\Front\MentorOccupationController;
use App\Http\Controllers\Front\MentorScheduleController;
use App\Http\Controllers\Front\MentorSkillController;
use App\Http\Controllers\Front\NewsletterController;
use App\Http\Controllers\Front\RatingController;
use App\Http\Controllers\Front\SmsController;
use App\Http\Controllers\Front\SocialAPIController;
use App\Http\Controllers\Front\UserLoginSignController;
use App\Http\Controllers\Front\UserOfflineController;
use App\Http\Controllers\Front\UserOnlineController;
use App\Http\Controllers\Front\WalletController;
use App\Http\Controllers\Front\WebNotificationController;
use App\Http\Controllers\Front\WithDrawRequestController;
use App\Http\Controllers\MeetingConfirmationController;
use App\Http\Controllers\PaymentGateway\FlutterWave;
use App\Http\Controllers\PaymentGateway\Gateway;
use App\Http\Controllers\PaymentGateway\Moneta\Moneta;
use App\Http\Controllers\PaymentGateway\Moneta\MonetaRequest;
use App\Models\BookAppointment;
use App\Models\Commission;
use App\Models\MeetingConflict;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Set Status online or offline And Broadcast TO channel
Route::post('/changeOnlineStatus', [UserOfflineController::class,'update'])->name('changeOnlineStatus');

Route::post('/auth/google',[SocialAPIController::class,'loginWithGoogle']);
Route::post('/auth/facebook',[SocialAPIController::class,'loginWithFacebook']);


Route::post('/signup-email',[UserLoginSignController::class,'signup_email' ]);
Route::post('/login-email',[UserLoginSignController::class,'login_email' ]);
Route::post('/login-signup',[UserLoginSignController::class,'loginSignup' ]);
//forgetPassword
Route::post('/forget-password',[UserLoginSignController::class,'forgetPassword']);
//resetPassword
Route::post('/reset-password',[UserLoginSignController::class,'resetPassword']);

//Store Firebase User Token
Route::post('/fcm-store-token', [WebNotificationController::class, 'storeToken'])->name('store.token');
//Get Firebase User Tokens
Route::get('/fcm-get-tokens', [WebNotificationController::class, 'getUserToken'])->name('get.tokens');
//Send Firebase Notification
Route::post('/send-web-notification', [WebNotificationController::class, 'sendWebNotification'])->name('send.webNotification');

//Get Top Rated Mentors
Route::get('/topRatedMentors',[MentorCategoryController::class,'getTopRatedMentor' ]);
// All blogs
Route::get('/blog/list',[BlogController::class,'allBlogs']);
Route::get('/featured-blogs',[BlogController::class,'allFeaturedPosts']);
//Blog Detail
Route::get('/blogDetail',[BlogController::class,'blogDetail']);
//Blog Detail with slug
Route::get('/blog-with-slug',[BlogController::class,'blogDetailWithSlug']);
//Contact Us
Route::post('/contactus',[ContactUsController::class,'save']);
//get Featured Mentor
Route::get('/get-featured-mentors',[MentorCategoryController::class,'featuredMentors']);
//Mentor Category Route
Route::get('/mentorCategories',[MentorCategoryController::class,'index' ]);

Route::get('/mentorCategoriesList',[MentorCategoryController::class,'CategoriesList' ]);
//Categories List Only for Web
Route::get('/mentorCategoriesListWeb',[MentorCategoryController::class,'CategoriesListWeb' ]);

Route::get('/mentorChildCategoriesList',[MentorCategoryController::class,'GetChildMentorCategories' ]);

//Category wise Mentors Route
Route::get('/mentors',[MentorCategoryController::class,'categoryMentor' ]);


//price Filter mentors with slug
Route::get('/mentors/price/range',[MentorCategoryController::class,'mentorWithPriceRange' ]);
//Category wise Mentors Route with Slug
Route::get('/mentors/with/slug',[MentorCategoryController::class,'categoryMentorWithSlug' ]);

//Get User Profile by Id
Route::get('/getUserById',[UserLoginSignController::class,'getUserByID']);

//get Categories with Mentors
Route::get('/categories/with/mentors',[MentorCategoryController::class,'categoriesWithMentors' ]);

//newsletter save
Route::post('/save-newsletter',[NewsletterController::class,'save']);

//execute payment
Route::post('/execute-payment',[Gateway::class,'index']);
Route::post('/execute-payment-ukassa',[Gateway::class,'ukassa']);
//FlutterWave
Route::get('/flutterwave-execute',[FlutterWave::class,'index']);


Route::get('/payment_methods',[PaymentMethodController::class,'index']);
Route::get('/notification_settings',[SettingsController::class,'notificationSettings']);
Route::get('/general_settings',[SettingsController::class,'generalSettings']);



// Route::group([
//     'middleware' => 'auth:api'
//   ], function() {

    //Generate Agora Token for Real Time Video Call
    Route::get('/agoraToken',[UserLoginSignController::class,'generate_token' ]);

    //Mentor Profile Completion and Approval Status
    Route::get('/mentorStatus',[UserLoginSignController::class,'mentorStatus' ]);
    //Mentor Completion Status
    Route::post('/mentorProfile',[UserLoginSignController::class,'mentorProfileCompletion']);
    //Appointment Booking route
    Route::post('/bookAppointment',[AppointmentBookingController::class,'bookAppointment']);
    Route::get('/appointmentDetails',[AppointmentBookingController::class,'appointment_detail']);

    //Pending Mentee Appointments List
    Route::get('/menteeAppointments',[AppointmentBookingController::class,'pendingAppointments']);
    //Status Wise All Mentee Appointments List
    Route::get('/all-status-menteeAppointments',[AppointmentBookingController::class,'statusWiseAllAppointments']);
     //Status Wise All Mentor Appointments List
    Route::get('/all-status-mentorAppointments',[AppointmentBookingController::class,'statusWiseAllAppointmentsForMentor']);

    //Completed Mentee Appointments List
    Route::get('/newMenteeAppointments',[AppointmentBookingController::class,'completedAppointments']);
    //Completed Mentor Appointments List
    Route::get('/mentorAppointments',[AppointmentBookingController::class,'completedMentorAppointments']);
    Route::get('/newMentorAppointments',[AppointmentBookingController::class,'pendingMentorAppointments']);
    Route::get('/mentorAppointmentsStatusWise',[AppointmentBookingController::class,'MentorAppointmentsStatusWise']);

    Route::post('/changeAppointmentStatus',[AppointmentBookingController::class,'acceptRejectAppointment']);


    //Categories with blogs
    Route::get('/categoriesBlogs',[BlogController::class,'categoryBlogList']);

    // Mentor Education
    Route::post('/mentorEducation',[MentorEducationController::class,'save']);
    Route::get('/mentorEducationList',[MentorEducationController::class,'list']);
    Route::post('/mentorEducationUpdate',[MentorEducationController::class,'update']);
    Route::post('/mentorEducationDelete',[MentorEducationController::class,'destroy']);


    //Mentor Experience
    Route::post('/mentorExperience',[MentorExperienceController::class,'save']);
    Route::get('/mentorExperienceList',[MentorExperienceController::class,'list']);
    Route::post('/mentorExperienceUpdate',[MentorExperienceController::class,'update']);
    Route::post('/mentorExperienceDelete',[MentorExperienceController::class,'destroy']);
    //mentor all and pending Appointment count
    Route::get('/mentorAppointmentCount',[AppointmentBookingController::class,'appointmentCount']);
    //Mentor Cancel and all appointment Count
    Route::get('/appointment-count',[AppointmentBookingController::class,'allCancelappointmentCount']);

    //Update Mentor Profile Details
    Route::post('/updateMentorProfile',[UserLoginSignController::class,'updateProfile']);

    //Mentor Degree List
    Route::get('/degreeList',[MentorDegreeController::class,'list']);
    //Mentor Occupation List
    Route::get('/occupationList',[MentorOccupationController::class,'list']);
    //Mentor Banks List
    Route::get('/bankslist',[CountryController::class,'banks']);
    //Countries List
    Route::get('/countries',[CountryController::class,'countries_list']);
    //Country Cities List
    Route::get('/cities',[CountryController::class,'cities_list']);
    //Generic APi for Mentor (Occupations,banks,degrees)
    Route::get('/generic_mentor',[CountryController::class,'generic_mentor_records']);
    //Save Mentor Card Detail
    Route::post('/mentor_card',[MentorCardController::class,'save']);
    Route::get('/mentor_card_show',[MentorCardController::class,'show']);
    Route::post('/mentor_card_update',[MentorCardController::class,'update']);

    //Save Mentor Category
    Route::post('/mentorSkill',[MentorSkillController::class,'save']);
    Route::post('/mentorSkillDelete',[MentorSkillController::class,'delete']);
    Route::get('/mentorSkillSelected',[MentorSkillController::class,'selectCategory']);
    //Chat Routes
    //Fetch Messages
    Route::get('/fetch-messages',[ChatController::class,'fetchMessages']);
    //Save Messages
    Route::post('/send-message',[ChatController::class,'sendMessage']);

    //save mentor Schedule
    Route::post('/save-mentor-schedule',[MentorScheduleController::class,'save']);
    //save Mentor Chat Fee
    Route::post('/save-mentor-chat-fee',[MentorScheduleController::class,'saveAppointmentTypeChat']);
    //get Mentor Chat Fee
    Route::get('/get-mentor-chat-fee',[MentorScheduleController::class,'getChatFee']);
    //get Mentor Schedule
    Route::get('/get-mentor-schedules', [MentorScheduleController::class,'getMentorSchedule']);


    //Delete Mentor Schedule
    Route::post('/delete-mentor-schedule',[MentorScheduleController::class,'deleteMentorSchedule']);
    //get Appointment Types
    Route::get('/appointmenttypes',[CountryController::class,'appointmentTypes']);
    //Save Mentor Holiday Date
    Route::post('/save-holiday-date',[MentorScheduleController::class,'saveHolidayDate']);
    //Get Mentor Holiday Dates
    Route::get('/get-holiday-date',[MentorScheduleController::class,'getHolidayDate']);
    //Update Mentor holiday Date
    Route::post('/update-holiday-date',[MentorScheduleController::class,'updateHolidayDate']);

    //Payment Gateway APi

    //JassCash Payment Gateway

    Route::post('makeJazzcashPayment', [JazzcashGatewayController::class, 'createCharge']);

    //get available days for mentor Schedule
    Route::get('/get-available-days',[MentorScheduleController::class,'getAvailableDays']);
    //get available days for mentor Schedule for web
    Route::get('/get-available-days-web',[MentorScheduleController::class,'getAvailableDaysWeb']);

    //mark Day as holiday For Mentor Schedule
    Route::post('/mark-day-holiday',[MentorScheduleController::class,'markDayHoliday']);
    //Search Book Appointments for Mentor
    Route::get('/search-appointment',[AppointmentBookingController::class,'searchAppointment']);
    //search Book appointment for Mentee
    Route::get('/search-appointment-mentee',[AppointmentBookingController::class,'searchAppointmentMentee']);

    //Filter Book Appointments for Mentor
    Route::get('/filter-appointment',[AppointmentBookingController::class,'filterAppointments']);
    //Filter Book Appointment for Mentee
    Route::get('/filter-appointment-mentee',[AppointmentBookingController::class,'filterAppointmentsMentee']);

    //Search Mentor
    Route::get('/search-mentor',[MentorCardController::class,'searchMentor']);
    //Search Mentor For web
    Route::get('/search-mentor-web',[MentorCardController::class,'searchMentorWeb']);

    //Search Featured Mentors For mobile
    Route::get('/search-mentor-mobile',[MentorCardController::class,'searchMentorMobile']);

    //Search Featured Mentors For web
    Route::get('/search-featured-mentor-web',[MentorCardController::class,'searchFeaturedMentors']);
    //search Category
    Route::get('/search-category',[MentorCardController::class,'searchcategory']);
    //Get Mentor Schedule by Date of Day
    Route::get('/get-date-schedule',[MentorScheduleController::class,'getMentorDateSchedule']);
    //Get Available Mentor Schedule Type
    Route::get('/available-schedule-types',[MentorScheduleController::class,'availableMentorAppointmentTypes']);
    //Mentor Today's Accepted Appointment
    Route::get('/today-appointments',[AppointmentBookingController::class,'getTodayAppointment']);
    //Get Mentor Fee By Appointment
    Route::get('/get-mentor-fee',[MentorScheduleController::class,'getMentorFeeByAppointmentType']);
    //Create Rating
    Route::post('/create-rating',[RatingController::class,'createRating']);
    //get Rating
    Route::get('/get-rating',[RatingController::class,'getRatings']);
    //get Ratings Details
    Route::get('/get-ratings-detail',[RatingController::class,'getRatingDetails']);
    //rating exist for Appointment
    Route::get('/rating-exist-appointment',[RatingController::class,'ratingExistAppointment']);

    //mark appointment Completed todo:удалить, если всё будет хорошо работать (комм от 20.12.22)
    // Route::post('/mark-appointment-as-complete', [AppointmentBookingController::class, 'markAppointmentAsComplete']);
    //get mentor limited Details
    Route::get('/get-mentor-details',[UserLoginSignController::class,'getMentorPublicDetails']);
    //Wallet Standard Features

    //deposit Amount into Wallet
    Route::post('/deposit-wallet',[WalletController::class,'depositWallet']);
    //Withdraw Amount From Wallet
    Route::post('/withdraw-wallet',[WalletController::class,'withDrawWallet']);
    //Wallet Transaction Histroy
    Route::get('/wallet-history',[WalletController::class,'transactionsHistory']);
    //Check Balance Of Wallet
    Route::get('/check-balance',[WalletController::class,'checkBalance']);
    //deposit Amount into Wallet Using Jazzcash
    Route::post('/deposit-wallet-jazzcash',[JazzcashGatewayController::class,'createChargeForWallet']);

    //WithDraw REquest from mentor for Admin todo:удалить, если всё будет хорошо работать (комм от 20.12.22)
    // Route::post('/withdraw-request',[WithDrawRequestController::class,'createWithDrawRequest']);

    //Wallet Credit Transfer on Appointment book
    Route::post('/wallet-credit-transfer',[WalletController::class,'transferCredit']);
    //get  User Location
    Route::get('/get-user-location',[MentorCardController::class,'getUserLocation']);
    //check if appointment exist for date and time
    Route::get('/appointment-exist',[AppointmentBookingController::class,'appointmentExistForDateTime']);
    //get scheduled available Days
    Route::get('/get-scheduled-available-days',[MentorScheduleController::class,'getScheduledAvailableDays']);
    //update Mentee Profile
    Route::post('/update-mentee-profile',[MenteeProfileController::class,'updateProfile']);
    //fetch Mentee Profile
    Route::get('/get-mentee-profile',[MenteeProfileController::class,'getMenteeProfile']);
    //toggle Visiblity of Profile
    Route::post('/toggle-visibility',[MenteeProfileController::class,'toggleIdentityVisiblity']);


    //Send Message using twilio
    Route::post('/send-sms',[SmsController::class,'send_message']);
    //Turn Live To Mentor
    Route::post('turn-live-mentor',[UserOfflineController::class,'turnLiveToMentor']);
    //Turn inactive To Mentor
    Route::post('/turn-inactive-mentor',[UserOfflineController::class,'offLiveToMentor']);
    Route::post('/flutter-wave-after-payment',[FlutterWave::class,'updateAppointment']);
    Route::get('/happy-clients',[FlutterWave::class,'happyClients']);
//   });
Route::post('/store-mentor',[MentorController::class,'saveMentor']);
Route::post('/store-skills',[MentorController::class,'saveSkills']);

Route::post('/store-bank',[MentorController::class,'saveBank']);
Route::post('/store-education',[MentorController::class,'saveEducation']);
Route::post('/store-experience',[MentorController::class,'saveExperience']);
Route::post('/appointment-attachments',[AppointmentBookingController::class,'appoinmentsAttachment']);
// Route::get('/payTm-order/{appointmentID}/{mobile_no}/{email}',[AppointmentBookingController::class,'payTmorder']);
// Route::post('/payTm-callback',[AppointmentBookingController::class,'payTmpaymentCallback']);



//Archieve Appointment Mentor
Route::get('/mentor/archieve-appointments',[AppointmentBookingController::class,'mentorArchieveAppointments']);
Route::get('/mentor/search-archieve-appointments',[AppointmentBookingController::class,'searchArchieveAppointment']);
Route::post('/mentor/archieved-appointment',[AppointmentBookingController::class,'mentorArchievedAppointment']);
Route::post('/mentor/unarchieved-appointment',[AppointmentBookingController::class,'mentorUnarchievedAppointment']);
//Archieve Appointment Mentee
Route::get('/mentee/archieve-appointments',[AppointmentBookingController::class,'menteeArchieveAppointments']);
Route::get('/mentee/search-archieve-appointments',[AppointmentBookingController::class,'menteesearchArchieveAppointment']);
Route::post('/mentee/archieved-appointment',[AppointmentBookingController::class,'menteeArchievedAppointment']);
Route::post('/mentee/unarchieved-appointment',[AppointmentBookingController::class,'menteeUnarchievedAppointment']);

Route::get('/testinomials',[TestinomialsController::class,'allTestinomials']);
Route::get('/terms_conditions',[TermsConditionsController::class,'getTermsConditions']);


// Монета (платёжная система)
Route::prefix('Moneta')->group(function (){
    Route::get('getCondition', [Moneta::class, 'getCondition']);
    Route::get('createAccount', [Moneta::class, 'createAccount']);
    Route::post('/createProfile',[Moneta::class,'createProfile']);
    Route::post('/checkPhoneCode', [Moneta::class,'checkPhoneCode']);
    Route::get('MonetaNotifications', [Moneta::class,'callbackNotify'])->name('MonetaNotifications');
    Route::post('MonetaNotifications', [Moneta::class,'callbackNotify']);
    Route::get('asyncRequest/{id}', function($id){
        $SimplifiedIdentificationRequest = new MonetaRequest([
            'AsyncRequest' => [
                'asyncId' => $id
            ]
        ]);
        return $SimplifiedIdentificationRequest->send();
    });
    Route::post('getPaymentFormLink', [Moneta::class, 'getPaymentFormLink']);
    Route::post('createWithdrawOrder', [Moneta::class, 'createWithdrawOrder']);
    Route::any('paymentNotification', function (Request $request){
        $md = md5($request->MNT_ID.$request->MNT_TRANSACTION_ID.$request->MNT_OPERATION_ID.$request->MNT_AMOUNT.$request->MNT_CURRENCY_CODE.$request->MNT_SUBSCRIBER_ID.$request->MNT_TEST_MODE.'bKHSguefnjs');

        Log::channel('moneta')->debug('PAYMENT_NOTIFY('.$md.'): '.json_encode($request->all()));
        if ($request->MNT_SIGNATURE != $md) throw new Exception('Ошибка цифровой подписи');

        if($request->addCardMode != null || $request->addCardMode == 1){
            Log::channel('moneta')->debug('Режим добавления карты');
            $user = User::where('moneta->account_id', $request->MNT_ID)->first();
            $user->moneta['operation_id'] = $request->MNT_OPERATION_ID;
            $user->save();
            Moneta::returnByOperationId($request->MNT_OPERATION_ID);
            return 'SUCCESS';
        }

        $commission=Commission::first();

        if($commission->fixed){
            $customer_amount = $request->MNT_AMOUNT - $commission->amount;
        }else {
            $amount = $request->MNT_AMOUNT * $commission->amount / 100;
            $customer_amount = $request->MNT_AMOUNT - $amount;
        }
        $user = User::find($request->mentor_id);
        $transaction = $user->deposit($customer_amount, ['MNT_OPERATION_ID' => $request->MNT_OPERATION_ID], false);

        $bookAppointment = BookAppointment::find($request->MNT_TRANSACTION_ID);
        $bookAppointment->is_paid = true;
        $bookAppointment->payment_id = $transaction->id;
        $bookAppointment->save();

        return 'SUCCESS';
    });
});

Route::post('mark-appointment-as-complete', [MeetingConfirmationController::class, 'MentorConfirm']);
Route::post('customerConfirm', [MeetingConfirmationController::class, 'CustomerConfirm']);
Route::post('resolveConflict', [MeetingConfirmationController::class, 'ResolveConflict']);
Route::get('/cancelAppointment/{id}', function ($id){
    MeetingConfirmationController::CancelMeeting(BookAppointment::find($id));
});
Route::get('conflicts', function(){
   return MeetingConflict::with(['bookAppointment'])->get();
});
Route::get('conflicts/{id}/inProcess', function($id){
    $mc = MeetingConflict::where('id', $id)->with(['bookAppointment'])->first();
    $mc->status = 'processing';
    $mc->save();
    return MeetingConflict::with(['bookAppointment'])->get();
});
Route::get('conflicts/{id}', function($id){
    return MeetingConflict::where('id', $id)->with(['bookAppointment'])->get();
});
