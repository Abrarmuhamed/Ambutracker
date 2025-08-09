<div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <h5 class="fw-bold mb-0"><span class="text-theme">Logout</span> Your Account!</h5>
                <p>To logout your account, please click below buttton.</p>
                <form method="post" action="functions/functions.php">
                    <button type="button" class="btn btn-secondary btn-sm py-2 px-4 rounded-pill" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="submit" name="logout" class="btn btn-theme btn-sm py-2 px-4 rounded-pill">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="settingsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <h5 class="fw-bold mb-0"><span class="text-theme">Driver</span> Settings</h5>
                <p>You can customize settings here</p>

                <form action="functions/function.php" method="post">
                    <div class="mb-3 text-start">
                        <label for="status" class="form-label">Driver Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Ready">Ready</option>
                            <option value="Busy">Busy</option>
                        </select>
                    </div>
                    <button type="submit" name="uodate_status" class="btn btn-theme btn-sm"><i class="bi bi-floppy"></i> Save</button>
                    <a href="register-home" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="assets/js/main.js"></script>