<?php

namespace App\Models\Customer;

use App\Models\Customer\Setting\Setting;
use App\Models\Meeting\Document\Document;
use App\Models\Meeting\Hall\Hall;
use App\Models\Meeting\Hall\Program\Chair\Chair;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Debate\Team\Team;
use App\Models\Meeting\Hall\Program\Debate\Vote\Vote;
use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use App\Models\Meeting\Hall\Program\Session\Session;
use App\Models\Meeting\Hall\Screen\Screen;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\Participant\Participant;
use App\Models\Meeting\ScoreGame\QRCode\QRCode;
use App\Models\Meeting\ScoreGame\ScoreGame;
use App\Models\Meeting\Survey\Question\Question;
use App\Models\Meeting\Survey\Survey;
use App\Models\User\Role\Role;
//use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'customers';
    protected $fillable = [
        'code',
        'title',
        'icon',
        'logo',
        'credit',
        'language',
        'status',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function documents()
    {
        $documents = Document::select('meeting_documents.*')
            ->join('meetings', 'meeting_documents.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $documents;
    }
    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'customer_id', 'id');
    }
    public function halls()
    {
        return $this->hasOneThrough(Hall::class, Meeting::class, 'customer_id', 'meeting_id', 'id', 'id');
    }

    public function surveys()
    {
        return $this->hasOneThrough(Survey::class, Meeting::class, 'customer_id', 'meeting_id', 'id', 'id');
    }
    public function participants()
    {
        return $this->hasOneThrough(Participant::class, Meeting::class, 'customer_id', 'meeting_id', 'id', 'id');
    }
    public function participantsLastLogin()
    {
        return $this->hasOneThrough(Participant::class, Meeting::class, 'customer_id', 'meeting_id', 'id', 'id')->orderBy('meeting_participants.last_login_datetime');
    }
    public function programs()
    {
        $programs = Program::select('meeting_hall_programs.*')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $programs;
    }
    public function screens()
    {
        $screens = Screen::select('meeting_hall_screens.*')
            ->join('meeting_halls', 'meeting_hall_screens.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $screens;
    }
    public function programChairs()
    {
        $chairs = Chair::select('meeting_hall_program_chairs.*')
            ->join('meeting_hall_programs', 'meeting_hall_program_chairs.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $chairs;
    }
    public function programSessions()
    {
        $program_sessions = Session::select('meeting_hall_program_sessions.*')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $program_sessions;
    }
    public function debates()
    {
        $debates = Debate::select('meeting_hall_program_debates.*')
            ->join('meeting_hall_programs', 'meeting_hall_program_debates.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $debates;
    }
    public function teams()
    {
        $teams = Team::select('meeting_hall_program_debate_teams.*')
            ->join('meeting_hall_program_debates', 'meeting_hall_program_debate_teams.debate_id', '=', 'meeting_hall_program_debates.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_debates.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $teams;
    }
    public function keypads()
    {
        $keypads = Keypad::select('meeting_hall_program_session_keypads.*')
            ->join('meeting_hall_program_sessions', 'meeting_hall_program_session_keypads.session_id', '=', 'meeting_hall_program_sessions.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $keypads;
    }
    public function sessionQuestions()
    {
        $questions = \App\Models\Meeting\Hall\Program\Session\Question\Question::select('meeting_hall_program_session_questions.*')
            ->join('meeting_hall_program_sessions', 'meeting_hall_program_session_questions.session_id', '=', 'meeting_hall_program_sessions.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $questions;
    }
    public function options()
    {
        $keypads = Option::select('meeting_hall_program_session_keypad_options.*')
            ->join('meeting_hall_program_session_keypads', 'meeting_hall_program_session_keypad_options.keypad_id', '=', 'meeting_hall_program_session_keypads.id')
            ->join('meeting_hall_program_sessions', 'meeting_hall_program_session_keypads.session_id', '=', 'meeting_hall_program_sessions.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $keypads;
    }
    public function surveyOptions()
    {
        $options = \App\Models\Meeting\Survey\Question\Option\Option::select('meeting_survey_question_options.*')
            ->join('meeting_survey_questions', 'meeting_survey_question_options.question_id', '=', 'meeting_survey_questions.id')
            ->join('meeting_surveys', 'meeting_survey_questions.survey_id', '=', 'meeting_surveys.id')
            ->join('meetings', 'meeting_surveys.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $options;
    }
    public function surveyQuestions()
    {
        $questions = Question::select('meeting_survey_questions.*')
            ->join('meeting_surveys', 'meeting_survey_questions.survey_id', '=', 'meeting_surveys.id')
            ->join('meetings', 'meeting_surveys.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $questions;
    }
    public function debateVotes()
    {
        $votes = Vote::select('meeting_hall_program_debate_votes.*')
            ->join('meeting_hall_program_debates', 'meeting_hall_program_debate_votes.debate_id', '=', 'meeting_hall_program_debates.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_debates.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $votes;
    }
    public function keypadVotes()
    {
        $votes = \App\Models\Meeting\Hall\Program\Session\Keypad\Vote\Vote::select('meeting_hall_program_session_keypad_votes.*')
            ->join('meeting_hall_program_session_keypads', 'meeting_hall_program_session_keypad_votes.keypad_id', '=', 'meeting_hall_program_session_keypads.id')
            ->join('meeting_hall_program_sessions', 'meeting_hall_program_session_keypads.session_id', '=', 'meeting_hall_program_sessions.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $votes;
    }
    public function surveyVotes()
    {
        $surveyVotes = \App\Models\Meeting\Survey\Vote\Vote::select('meeting_survey_votes.*')
            ->join('meeting_surveys', 'meeting_survey_votes.survey_id', '=', 'meeting_surveys.id')
            ->join('meetings', 'meeting_surveys.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $surveyVotes;
    }
    public function surveyParticipants()
    {
        $surveyParticipants = \App\Models\Meeting\Survey\Vote\Vote::select('meeting_survey_votes.*')
            ->join('meeting_participants', 'meeting_survey_votes.participant_id', '=', 'meeting_participants.id')
            ->join('meetings', 'meeting_participants.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $surveyParticipants;
    }
    public function settings()
    {
     $settings = Setting::select('system_setting_variables.*', 'customer_settings.*')
            ->join('system_setting_variables', 'customer_settings.variable_id','=', 'system_setting_variables.id')
            ->join('customers', 'customer_settings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $settings;
    }
    public function scoreGames()
    {
        return $this->hasOneThrough(ScoreGame::class, Meeting::class, 'customer_id', 'meeting_id', 'id', 'id');
    }
    public function qrCodes()
    {
        $qrcodes = QRCode::select('meeting_score_game_qr_codes.*')
            ->join('meeting_score_games', 'meeting_score_game_qr_codes.score_game_id', '=', 'meeting_score_games.id')
            ->join('meetings', 'meeting_score_games.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $qrcodes;
    }
    public function users()
    {
        return $this->hasMany(User::class, 'customer_id', 'id');
    }
    public function userRoles()
    {
        return $this->hasMany(Role::class, 'customer_id', 'id');
    }

}
