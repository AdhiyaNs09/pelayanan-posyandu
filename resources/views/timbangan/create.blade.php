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
                                        <option value="{{ $item['id'] }}" data-nik_orangtua="{{ $item['nik_orangtua'] }}">
                                            {{ $item['nama'] }} (NIK Orangtua: {{ $item['nik_orangtua'] }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Hidden input untuk nik_orangtua -->
                            <input type="hidden" id="nik_orangtua" name="nik_orangtua">
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

        const firebaseConfig = {
            apiKey: "AIzaSyBO-n5zjICpWIPPq7j_4iR59MVK_RLB5eo",
            authDomain: "timbangan-ff98c.firebaseapp.com",
            databaseURL: "https://timbangan-ff98c-default-rtdb.asia-southeast1.firebasedatabase.app/",
            projectId: "timbangan-ff98c",
            storageBucket: "timbangan-ff98c.firebasestorage.app",
            messagingSenderId: "297905665446",
            appId: "1:297905665446:web:d43a145139e2ce3e72cb67",
            measurementId: "G-D77YVMY6GR"
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
    <script>
        document.getElementById('anak_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const nikOrangtua = selectedOption.getAttribute('data-nik_orangtua');
            document.getElementById('nik_orangtua').value = nikOrangtua;
        });
    </script>
@endsection
