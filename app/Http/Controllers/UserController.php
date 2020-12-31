<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private $user;

    /**
     * AuthController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['users' =>  $this->user->all()], 200);
    }

    /**
     * Get one user.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $user = $this->user->findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        $user = $this->user->findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $this->user->findOrFail($id)->delete();

            return response()->json('Deleted Successfully', 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }
}
