@extends('admin.layouts.admin_layout')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li><a href="{{ route('admin.home') }}">Ana Sayfa</a><i class="fa fa-circle"></i></li>
                <li><a href="{{ route('admin.job-posts.index') }}">İlanlar</a><i class="fa fa-circle"></i></li>
                <li><span>{{ Str::limit($post->title, 40) }}</span></li>
            </ul>
        </div>

        <div class="row">
            {{-- Left: Post Details --}}
            <div class="col-md-7">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="fa fa-list-alt font-dark"></i>
                            <span class="caption-subject bold uppercase">{{ $post->title }}</span>
                        </div>
                        <div class="actions">
                            <span class="label label-{{ $post->status === 'published' ? 'success' : ($post->status === 'matched' ? 'info' : ($post->status === 'draft' ? 'default' : 'danger')) }} label-lg">
                                {{ $statusLabels[$post->status] ?? $post->status }}
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-bordered">
                            <tr><th style="width:160px;">İlan Sahibi</th>
                                <td>{{ $post->owner?->getName() }} <small class="text-muted">&lt;{{ $post->owner?->email }}&gt;</small></td></tr>
                            <tr><th>Tür</th>
                                <td>{{ $post->category_type === 'caregiver' ? '🧑‍⚕️ Bakıcı' : '🔧 Hizmet' }}
                                    @if($post->category) — {{ $post->category->category_name }} @endif</td></tr>
                            <tr><th>Lokasyon</th>
                                <td>{{ $post->state?->state ?? '—' }}{{ $post->city ? ' / ' . $post->city->city : '' }}</td></tr>
                            <tr><th>Çalışma Tipi</th>
                                <td>{{ $post->getWorkTypeLabel() }}
                                    @if($post->work_hours_start && $post->work_hours_end)
                                        ({{ $post->work_hours_start }} – {{ $post->work_hours_end }})
                                    @endif
                                </td></tr>
                            <tr><th>Min. Deneyim</th><td>{{ $post->min_experience_years }} yıl</td></tr>
                            <tr><th>Ücret Aralığı</th><td>{{ $post->getSalaryRange() }}</td></tr>
                            <tr><th>Sertifika</th><td>{{ $post->requires_certificate ? '✅ Gerekli' : 'Gerekmiyor' }}</td></tr>
                            <tr><th>Referans</th><td>{{ $post->requires_reference ? '✅ Zorunlu' : 'Zorunlu değil' }}</td></tr>
                            <tr><th>Başvuru Sayısı</th><td>{{ $post->applications_count }}</td></tr>
                            <tr><th>Yayın Tarihi</th><td>{{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : '—' }}</td></tr>
                            @if($post->matched_user_id && $post->matchedUser)
                                <tr><th>Eşleşen Kişi</th>
                                    <td><strong>{{ $post->matchedUser->getName() }}</strong>
                                        {{ $post->matched_at ? '— ' . $post->matched_at->format('d.m.Y') : '' }}</td></tr>
                            @endif
                        </table>

                        @if($post->requirements->isNotEmpty())
                            <h5><i class="fa fa-list"></i> Gereksinimler</h5>
                            <ul>
                                @foreach($post->requirements as $req)
                                    <li>
                                        <span class="label label-default">{{ $req->requirement_type }}</span>
                                        {{ $req->requirement_value }}
                                        @if($req->is_mandatory) <span class="label label-danger">Zorunlu</span> @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if($post->description)
                            <h5 style="margin-top:15px;"><i class="fa fa-file-text"></i> Açıklama</h5>
                            <p style="color:#555; line-height:1.7; white-space:pre-line;">{{ $post->description }}</p>
                        @endif

                        {{-- Admin Actions --}}
                        <div style="margin-top:20px; display:flex; gap:8px; flex-wrap:wrap;">
                            @if($post->status === 'published')
                                <form action="{{ route('admin.job-posts.close', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf <button class="btn btn-sm red"><i class="fa fa-lock"></i> Kapat</button>
                                </form>
                                <form action="{{ route('admin.job-posts.suspend', $post->id) }}" method="POST" style="display:inline;"
                                    onsubmit="return confirm('Bu ilan askıya alınacak. Devam?')">
                                    @csrf <button class="btn btn-sm yellow"><i class="fa fa-pause"></i> Askıya Al</button>
                                </form>
                            @elseif(in_array($post->status, ['closed','cancelled','draft']))
                                <form action="{{ route('admin.job-posts.publish', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf <button class="btn btn-sm green"><i class="fa fa-globe"></i> Yayınla</button>
                                </form>
                            @endif
                            <a href="{{ route('admin.job-posts.index') }}" class="btn btn-sm default"><i class="fa fa-arrow-left"></i> Geri</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Applications --}}
            <div class="col-md-5">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="fa fa-users font-dark"></i>
                            <span class="caption-subject bold uppercase">Başvurular ({{ $applications->total() }})</span>
                        </div>
                    </div>
                    <div class="portlet-body" style="padding:10px;">
                        @forelse($applications as $app)
                            <div style="display:flex; align-items:center; gap:10px; padding:10px; border-bottom:1px solid #f5f5f5;">
                                <img src="{{ $app->applicant?->image ? asset('uploads/user_images/'.$app->applicant->image) : asset('admin_assets/no-image.png') }}"
                                    style="width:36px; height:36px; border-radius:50%; object-fit:cover;">
                                <div style="flex:1;">
                                    <strong style="font-size:13px;">{{ $app->applicant?->getName() }}</strong><br>
                                    <small class="text-muted">{{ $app->applicant?->email }}</small>
                                </div>
                                @php $s = (float)$app->match_score; @endphp
                                <div style="text-align:center;">
                                    <span style="font-weight:800; font-size:14px; color:{{ $s>=70?'#065f46':($s>=40?'#92400e':'#991b1b') }};">
                                        %{{ number_format($s,0) }}
                                    </span>
                                    <div style="background:#f3f4f6; border-radius:4px; height:5px; margin-top:2px; width:60px; overflow:hidden;">
                                        <div style="width:{{ min($s,100) }}%;height:100%;background:{{ $s>=70?'#10b981':($s>=40?'#f59e0b':'#ef4444') }};"></div>
                                    </div>
                                </div>
                                <div>
                                    <span class="label label-{{ $statusColors[$app->status] ?? 'default' }}" style="font-size:11px;">
                                        {{ Str::limit($statusLabels[$app->status] ?? $app->status, 10) }}
                                    </span>
                                </div>
                                <a href="{{ route('admin.applications.show', $app->id) }}" class="btn btn-xs blue">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                        @empty
                            <p class="text-muted text-center" style="padding:20px;">Henüz başvuru yok.</p>
                        @endforelse
                        <div style="padding:10px;">{{ $applications->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
