@extends('layouts.master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Timbangan
                            <a href="{{ url('timbangan') }}" class="btn btn-sm btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ url('update-timbangan/' . $selectedData['nik_orangtua'] . '/' . $selectedData['anak_ke'] . '/' . $selectedData['tanggal_timbangan']) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label>Nama Anak</label>
                                <input type="text" class="form-control" value="{{ $selectedData['nama_anak'] }}"
                                    disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>Tanggal Timbangan</label>
                                <input type="text" name="tanggal_timbangan" class="form-control"
                                    value="{{ $selectedData['tanggal_timbangan'] }}" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>Berat Badan</label>
                                <input type="text" name="berat_badan" class="form-control" id="berat_badan" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Tinggi Badan</label>
                                <input type="text" name="tinggi_badan" class="form-control" id="tinggi_badan" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tambahkan Firebase Modular -->
    <script type="module">
        // Import Firebase Modular SDK
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-app.js";
        import {
            getDatabase,
            ref,
            onValue
        } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-database.js";

        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyBO-n5zjICpWIPPq7j_4iR59MVK_RLB5eo",
            authDomain: "timbangan-ff98c.firebaseapp.com",
            databaseURL: "https://timbangan-ff98c-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "timbangan-ff98c",
            storageBucket: "timbangan-ff98c.firebasestorage.app",
            messagingSenderId: "297905665446",
            appId: "1:297905665446:web:57fc986672afd26872cb67",
            measurementId: "G-571YGYVB2J"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const database = getDatabase(app);

        // Reference to Firebase Realtime Database
        const weightRef = ref(database, 'weight'); // Path data berat badan
        const heightRef = ref(database, 'height'); // Path data tinggi badan

        // Listener untuk berat badan
        onValue(weightRef, (snapshot) => {
            const weight = snapshot.val();
            console.log('Weight:', weight); // Debugging
            if (weight) {
                document.getElementById('berat_badan').value = weight;
            }
        });

        // Listener untuk tinggi badan
        onValue(heightRef, (snapshot) => {
            const height = snapshot.val();
            console.log('Height:', height); // Debugging
            if (height) {
                document.getElementById('tinggi_badan').value = height;
            }
        });
    </script>
@endsection
