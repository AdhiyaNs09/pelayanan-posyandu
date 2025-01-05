@extends('layouts.master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Timbangan
                            <a href="{{ url('timbangan') }}" class="btn btn-sm btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('tambah-timbangan') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="anak_id">Pilih Anak:</label>
                                <select id="anak_id" name="anak_id" class="form-control" required>
                                    <option value="">Pilih Anak</option>
                                    @foreach ($anak as $item)
                                        <option value="{{ $item['id'] }}">
                                            {{ $item['nama'] }} (NIK Orangtua: {{ $item['nik_orangtua'] }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>Tanggal Timbangan</label>
                                <input type="date" name="tanggal_timbangan" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Berat Badan</label>
                                <input type="text" name="berat_badan" class="form-control" id="berat_badan" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Tinggi Badan</label>
                                <input type="text" name="tinggi_badan" class="form-control" id="tinggi_badan" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Input</button>
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
            apiKey: "AIzaSyDkbd7UbQHTEANuT9quAdlIBX9LiRnwFj0",
            authDomain: "pelayanan-posyandu.firebaseapp.com",
            databaseURL: "https://pelayanan-posyandu-default-rtdb.firebaseio.com",
            projectId: "pelayanan-posyandu",
            storageBucket: "pelayanan-posyandu.appspot.com",
            messagingSenderId: "259403986465",
            appId: "1:259403986465:web:e1b434f4f1b083aa3c1560",
            measurementId: "G-XTGPLHNTLN"
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
