<?php

namespace App\Http\Controllers\Invoice\Admin;

use App\Models\Invoice\Project;
use App\Models\Invoice\Report;
use App\Models\Invoice\ReportProjects;
use App\Models\Invoice\ReportUsers;
use App\Models\Invoice\Task;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $reports = Report::all();
        $projects = Project::all();
        $users = User::where('invoice', 1)->where('status', 'user')->get();

        $prevUs = '';
        $prevProj = '';
        $tasks = Task::all();



        foreach ($tasks as $i => $task) {
            $flag = false;
            foreach ($reports as $report) {
                foreach ($report->reportProjects as $project) {
                    if(isset($tasks[$i])) {
                        if($tasks[$i]->project_id == $project->project_id) {
                            $flag = true;
                        }
                    }
                }
            }

            if(!$flag) {
                $tasks->forget($i);
            }
        }
        foreach ($tasks as $task) {
            foreach ($tasks as $t) {
                $h = 0;
                $m = 0;
                if ($task->project_id == $t->project_id && $task->user_id == $t->user_id && $task->id != $t->id) {
                    if (strpos($task->time, 'h') !== false && strpos($task->time, 'm') === false) {
                        $h += explode('h', $task->time)[0];
                    } else if (strpos($task->time, 'h') === false && strpos($task->time, 'm') !== false) {
                        $m += explode('m', $task->time)[0];
                    } else {
                        $tmp = explode(':', $task->time);
                        $h += explode('h', $tmp[0])[0];
                        $m += explode('m', $tmp[1])[0];
                    }

                    if (strpos($t->time, 'h') !== false && strpos($t->time, 'm') === false) {
                        $h += explode('h', $t->time)[0];
                    } else if (strpos($t->time, 'h') === false && strpos($t->time, 'm') !== false) {
                        $m += explode('m', $t->time)[0];
                    } else {
                        $tmp = explode(':', $t->time);
                        $h += explode('h', $tmp[0])[0];
                        $m += explode('m', $tmp[1])[0];
                    }

                    $h += floor($m / 60);
                    $m = $m % 60;
                    $time = $h . 'h:' . $m . 'm';

                    $task->time = $time;
                }
            }
        }

        foreach ($tasks as $i => $task) {
            foreach ($tasks as $j => $t) {
                if (isset($tasks[$i]) && isset($tasks[$j])) {
                    if ($tasks[$i]->id != $tasks[$j]->id && $tasks[$i]->user_id == $tasks[$j]->user_id && $tasks[$i]->project_id == $tasks[$j]->project_id) {
                        $tasks->forget($j);
                    }
                }
            }
        }

        foreach ($reports as $report) {
            foreach ($report->reportProjects as $i => $project) {
                $h = 0;
                $m = 0;
                $t = '';
                if(count($report->reportUsers) == 0) {
                    foreach ($tasks as $task) {
                        if ($task->project_id == $project->project_id) {
                            if (strpos($task->time, 'h') !== false && strpos($task->time, 'm') === false) {
                                $h += explode('h', $task->time)[0];
                            } else if (strpos($task->time, 'h') === false && strpos($task->time, 'm') !== false) {
                                $m += explode('m', $task->time)[0];
                            } else {
                                $tmp = explode(':', $task->time);
                                $h += explode('h', $tmp[0])[0];
                                $m += explode('m', $tmp[1])[0];
                            }

                            $h += floor($m / 60);
                            $m = $m % 60;
                            $time = $h . 'h:' . $m . 'm';

                            $t = $time;
                        }
                    }
                } else {
                    foreach ($report->reportUsers as $user) {
                        foreach ($tasks as $task) {
                            if ($task->project_id == $project->project_id && $task->user_id == $user->user_id) {
                                if (strpos($task->time, 'h') !== false && strpos($task->time, 'm') === false) {
                                    $h += explode('h', $task->time)[0];
                                } else if (strpos($task->time, 'h') === false && strpos($task->time, 'm') !== false) {
                                    $m += explode('m', $task->time)[0];
                                } else {
                                    $tmp = explode(':', $task->time);
                                    $h += explode('h', $tmp[0])[0];
                                    $m += explode('m', $tmp[1])[0];
                                }

                                $h += floor($m / 60);
                                $m = $m % 60;
                                $time = $h . 'h:' . $m . 'm';

                                $t = $time;
                            }
                        }
                    }
                }
                $project->time = $t;
            }
        }

        foreach ($tasks as $task) {
            foreach ($tasks as $t) {
                $h = 0;
                $m = 0;
                if ($task->user_id == $t->user_id && $task->id != $t->id) {
                    if (strpos($task->time, 'h') !== false && strpos($task->time, 'm') === false) {
                        $h += explode('h', $task->time)[0];
                    } else if (strpos($task->time, 'h') === false && strpos($task->time, 'm') !== false) {
                        $m += explode('m', $task->time)[0];
                    } else {
                        $tmp = explode(':', $task->time);
                        $h += explode('h', $tmp[0])[0];
                        $m += explode('m', $tmp[1])[0];
                    }

                    if (strpos($t->time, 'h') !== false && strpos($t->time, 'm') === false) {
                        $h += explode('h', $t->time)[0];
                    } else if (strpos($t->time, 'h') === false && strpos($t->time, 'm') !== false) {
                        $m += explode('m', $t->time)[0];
                    } else {
                        $tmp = explode(':', $t->time);
                        $h += explode('h', $tmp[0])[0];
                        $m += explode('m', $tmp[1])[0];
                    }

                    $h += floor($m / 60);
                    $m = $m % 60;
                    $time = $h . 'h:' . $m . 'm';

                    $task->time = $time;
                }
            }
        }

        foreach ($tasks as $i => $task) {
            foreach ($tasks as $j => $t) {
                if (isset($tasks[$i]) && isset($tasks[$j])) {
                    if ($tasks[$i]->id != $tasks[$j]->id && $tasks[$i]->user_id == $tasks[$j]->user_id) {
                        $tasks->forget($j);
                    }
                }
            }
        }

        $reportName = Report::where('slug', $request->get('report-link'))->first();

        return view('invoice.admin.reports.index', compact('reports', 'projects', 'users', 'tasks', 'reportName'));
    }

    public function store(Request $request)
    {
        $reports = new Report();
        $slug = Str::slug($request->name, '-');
        $from = $request->from;
        $from = explode('/', $from)[2] . '/' . explode('/', $from)[1] . '/' . explode('/', $from)[0];
        $to = $request->to;
        $to = explode('/', $to)[2] . '/' . explode('/', $to)[1] . '/' . explode('/', $to)[0];

        $reports->name = $request->name;
        $reports->slug = $slug;
        $reports->from = $from;
        $reports->to = $to;
        $reports->save();

        if (!is_null($request->projects)) {
            foreach ($request->projects as $project) {
                $reportProjects = new ReportProjects();
                $reportProjects->project_id = $project;
                $reportProjects->report_id = $reports->id;

                $reportProjects->save();
            }
        }
        if (!is_null($request->users)) {
            foreach ($request->users as $user) {
                $reportUsers = new ReportUsers();
                $reportUsers->user_id = $user;
                $reportUsers->report_id = $reports->id;

                $reportUsers->save();
            }
        }

        return back()->with('success', 'You created report!');
    }

    public function getProject(Request $request)
    {
        $arr = [];
        if (!is_null($request->id)) {
            foreach ($request->id as $item) {
                $project = Project::find($item);

                array_push($arr, $project);
            }
        }

        return response()->json(['projects' => $arr]);
    }

    public function getUsers(Request $request)
    {
        $arr = [];
        if (!is_null($request->id)) {
            if ($request->id == 'all') {
                $users = User::all();

                array_push($arr, $users);
            } else {
                foreach ($request->id as $item) {
                    $user = User::find($item);

                    array_push($arr, $user);
                }
            }
        }
        return response()->json(['users' => $arr]);
    }

    public function getReport(Request $request)
    {
        $report = Report::where('id', $request->id)->with('reportProjects', 'reportUsers')->first();

        return response()->json(['report' => $report]);
    }

    public function updateReport($id, Request $request)
    {
        $reports = Report::find($id);

        $slug = Str::slug($request->name, '-');
        $from = $request->from;
        $from = explode('/', $from)[2] . '/' . explode('/', $from)[1] . '/' . explode('/', $from)[0];
        $to = $request->to;
        $to = explode('/', $to)[2] . '/' . explode('/', $to)[1] . '/' . explode('/', $to)[0];

        $reports->name = $request->name;
        $reports->slug = $slug;
        $reports->from = $from;
        $reports->to = $to;
        $reports->save();

        ReportProjects::where('report_id', $id)->delete();
        ReportUsers::where('report_id', $id)->delete();

        if (!is_null($request->projects)) {
            foreach ($request->projects as $project) {
                $reportProjects = new ReportProjects();
                $reportProjects->project_id = $project;
                $reportProjects->report_id = $reports->id;

                $reportProjects->save();
            }
        }
        if (!is_null($request->users)) {
            foreach ($request->users as $user) {
                $reportUsers = new ReportUsers();
                $reportUsers->user_id = $user;
                $reportUsers->report_id = $reports->id;

                $reportUsers->save();
            }
        }

        return back()->with('success', 'Your report has been updated successfully!');
    }
}
